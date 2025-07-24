<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Rating;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Author::factory()->count(1000)->create();
        Category::factory()->count(3000)->create();

        $authorIds = Author::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();

        $bookChunks = 10000;
        for ($i = 0; $i < 10; $i++) {
            $books = [];

            for ($j = 0; $j < $bookChunks; $j++) {
                $books[] = [
                    'title' => fake()->sentence(3),
                    'author_id' => $authorIds[array_rand($authorIds)],
                    'category_id' => $categoryIds[array_rand($categoryIds)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('books')->insert($books);
            echo "Inserted " . ($i + 1) * $bookChunks . " books...\n";
        }

        $bookIds = Book::pluck('id')->toArray();
        $ratings = [];

        foreach ($bookIds as $index => $bookId) {
            $ratingCount = rand(1, 20);

            for ($r = 0; $r < $ratingCount; $r++) {
                $ratings[] = [
                    'book_id' => $bookId,
                    'score' => rand(1, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (($index + 1) % 1000 === 0) {
                DB::table('ratings')->insert($ratings);
                echo "Inserted ratings for " . ($index + 1) . " books...\n";
                $ratings = [];
            }
        }

        if (!empty($ratings)) {
            DB::table('ratings')->insert($ratings);
        }



        if (!empty($ratings)) {
            DB::table('ratings')->insert($ratings);
        }

        echo "Updating rating summary to books table...\n";

        $bookStats = Rating::selectRaw('book_id, AVG(score) as avg_rating, COUNT(*) as voter_count')
            ->groupBy('book_id')
            ->get();

        foreach ($bookStats as $stat) {
            Book::where('id', $stat->book_id)->update([
                'avg_rating' => number_format($stat->avg_rating, 2, '.', ''),
                'voter_count' => $stat->voter_count,
            ]);
        }

        echo "Rating summary updated to books table.\n";

        echo "Seeding finished!\n";
    }
}
