<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin Kullanıcı',
            'email' => 'admin@okul.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '0532 123 4567',
        ]);

        // Student users
        $students = [
            ['name' => 'Ahmet Yılmaz', 'email' => 'ahmet@okul.com', 'student_no' => '2024001', 'class' => '10-A', 'phone' => '0533 111 2233'],
            ['name' => 'Ayşe Demir', 'email' => 'ayse@okul.com', 'student_no' => '2024002', 'class' => '10-B', 'phone' => '0534 222 3344'],
            ['name' => 'Mehmet Kaya', 'email' => 'mehmet@okul.com', 'student_no' => '2024003', 'class' => '11-A', 'phone' => '0535 333 4455'],
            ['name' => 'Fatma Öztürk', 'email' => 'fatma@okul.com', 'student_no' => '2024004', 'class' => '11-B', 'phone' => '0536 444 5566'],
            ['name' => 'Ali Çelik', 'email' => 'ali@okul.com', 'student_no' => '2024005', 'class' => '12-A', 'phone' => '0537 555 6677'],
        ];

        foreach ($students as $student) {
            User::create(array_merge($student, [
                'password' => Hash::make('password123'),
                'role' => 'student',
            ]));
        }

        // Categories
        $categories = [
            ['name' => 'Roman', 'description' => 'Yerli ve yabancı romanlar', 'icon' => '📚'],
            ['name' => 'Bilim', 'description' => 'Bilim ve teknoloji kitapları', 'icon' => '🔬'],
            ['name' => 'Tarih', 'description' => 'Tarih ve kültür kitapları', 'icon' => '🏛️'],
            ['name' => 'Matematik', 'description' => 'Matematik ve istatistik kitapları', 'icon' => '📐'],
            ['name' => 'Edebiyat', 'description' => 'Şiir, deneme ve edebiyat eserleri', 'icon' => '✍️'],
            ['name' => 'Felsefe', 'description' => 'Felsefe ve düşünce kitapları', 'icon' => '🤔'],
            ['name' => 'Psikoloji', 'description' => 'Psikoloji ve kişisel gelişim', 'icon' => '🧠'],
            ['name' => 'Sanat', 'description' => 'Sanat ve müzik kitapları', 'icon' => '🎨'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Books
        $books = [
            ['title' => 'Tutunamayanlar', 'author' => 'Oğuz Atay', 'isbn' => '978-975-10-0001-1', 'category_id' => 1, 'publisher' => 'İletişim Yayınları', 'page_count' => 724, 'quantity' => 3, 'available' => 3, 'shelf_no' => 'A-01', 'description' => 'Türk edebiyatının başyapıtlarından biri.'],
            ['title' => 'Kürk Mantolu Madonna', 'author' => 'Sabahattin Ali', 'isbn' => '978-975-10-0002-2', 'category_id' => 1, 'publisher' => 'Yapı Kredi Yayınları', 'page_count' => 160, 'quantity' => 5, 'available' => 5, 'shelf_no' => 'A-01', 'description' => 'Sabahattin Ali\'nin ölümsüz romanı.'],
            ['title' => 'İnce Memed', 'author' => 'Yaşar Kemal', 'isbn' => '978-975-10-0003-3', 'category_id' => 1, 'publisher' => 'Yapı Kredi Yayınları', 'page_count' => 436, 'quantity' => 2, 'available' => 2, 'shelf_no' => 'A-02', 'description' => 'Anadolu\'nun destansı romanı.'],
            ['title' => 'Suç ve Ceza', 'author' => 'Fyodor Dostoyevski', 'isbn' => '978-975-10-0004-4', 'category_id' => 1, 'publisher' => 'İş Bankası Kültür Yayınları', 'page_count' => 687, 'quantity' => 3, 'available' => 3, 'shelf_no' => 'A-03', 'description' => 'Dünya edebiyatının en önemli eserlerinden.'],
            ['title' => 'Cosmos', 'author' => 'Carl Sagan', 'isbn' => '978-975-10-0005-5', 'category_id' => 2, 'publisher' => 'Altın Kitaplar', 'page_count' => 432, 'quantity' => 2, 'available' => 2, 'shelf_no' => 'B-01', 'description' => 'Evrenin büyüleyici hikayesi.'],
            ['title' => 'Kısa Tarih', 'author' => 'Yuval Noah Harari', 'isbn' => '978-975-10-0006-6', 'category_id' => 3, 'publisher' => 'Kolektif Kitap', 'page_count' => 534, 'quantity' => 4, 'available' => 4, 'shelf_no' => 'C-01', 'description' => 'İnsanlığın kısa tarihi.'],
            ['title' => 'Matematik ve Sanat', 'author' => 'Atilla Baki', 'isbn' => '978-975-10-0007-7', 'category_id' => 4, 'publisher' => 'Pegem Yayınları', 'page_count' => 256, 'quantity' => 2, 'available' => 2, 'shelf_no' => 'D-01', 'description' => 'Matematik ve sanat arasındaki bağ.'],
            ['title' => 'Şeker Portakalı', 'author' => 'José Mauro de Vasconcelos', 'isbn' => '978-975-10-0008-8', 'category_id' => 5, 'publisher' => 'Can Yayınları', 'page_count' => 182, 'quantity' => 6, 'available' => 6, 'shelf_no' => 'A-04', 'description' => 'Dünya klasikleri arasında yer alan eser.'],
            ['title' => 'Sofinin Dünyası', 'author' => 'Jostein Gaarder', 'isbn' => '978-975-10-0009-9', 'category_id' => 6, 'publisher' => 'Pan Yayıncılık', 'page_count' => 550, 'quantity' => 3, 'available' => 3, 'shelf_no' => 'E-01', 'description' => 'Felsefe tarihine eğlenceli bir giriş.'],
            ['title' => 'Beyaz Diş', 'author' => 'Jack London', 'isbn' => '978-975-10-0010-0', 'category_id' => 1, 'publisher' => 'İş Bankası Kültür Yayınları', 'page_count' => 248, 'quantity' => 2, 'available' => 2, 'shelf_no' => 'A-05', 'description' => 'Vahşi doğada hayatta kalma mücadelesi.'],
            ['title' => 'Dönüşüm', 'author' => 'Franz Kafka', 'isbn' => '978-975-10-0011-1', 'category_id' => 5, 'publisher' => 'Can Yayınları', 'page_count' => 80, 'quantity' => 4, 'available' => 4, 'shelf_no' => 'A-06', 'description' => 'Kafka\'nın ölümsüz eseri.'],
            ['title' => 'Nutuk', 'author' => 'Mustafa Kemal Atatürk', 'isbn' => '978-975-10-0012-2', 'category_id' => 3, 'publisher' => 'Türk Tarih Kurumu', 'page_count' => 900, 'quantity' => 5, 'available' => 5, 'shelf_no' => 'C-02', 'description' => 'Türkiye Cumhuriyeti\'nin kuruluş hikayesi.'],
            ['title' => 'Olasılıksız', 'author' => 'Adam Fawer', 'isbn' => '978-975-10-0013-3', 'category_id' => 4, 'publisher' => 'Sonsuz Kitap', 'page_count' => 464, 'quantity' => 2, 'available' => 2, 'shelf_no' => 'D-02', 'description' => 'Matematik ve bilim kurgu.'],
            ['title' => 'Hayvan Çiftliği', 'author' => 'George Orwell', 'isbn' => '978-975-10-0014-4', 'category_id' => 1, 'publisher' => 'Can Yayınları', 'page_count' => 128, 'quantity' => 3, 'available' => 3, 'shelf_no' => 'A-07', 'description' => 'Siyasi bir alegori klasiği.'],
            ['title' => 'Sefiller', 'author' => 'Victor Hugo', 'isbn' => '978-975-10-0015-5', 'category_id' => 1, 'publisher' => 'İş Bankası Kültür Yayınları', 'page_count' => 1200, 'quantity' => 2, 'available' => 2, 'shelf_no' => 'A-08', 'description' => 'Victor Hugo\'nun başyapıtı.'],
            ['title' => 'Psikolojiye Giriş', 'author' => 'Morgan vd.', 'isbn' => '978-975-10-0016-6', 'category_id' => 7, 'publisher' => 'Eğitim Kitabevi', 'page_count' => 640, 'quantity' => 3, 'available' => 3, 'shelf_no' => 'F-01', 'description' => 'Psikolojiye kapsamlı bir giriş.'],
            ['title' => 'Sanat Tarihi', 'author' => 'Ernst Gombrich', 'isbn' => '978-975-10-0017-7', 'category_id' => 8, 'publisher' => 'Remzi Kitabevi', 'page_count' => 688, 'quantity' => 2, 'available' => 2, 'shelf_no' => 'G-01', 'description' => 'Sanat tarihinin en kapsamlı eseri.'],
            ['title' => 'Fizik ve Ötesi', 'author' => 'Fritjof Capra', 'isbn' => '978-975-10-0018-8', 'category_id' => 2, 'publisher' => 'Yol Yayınları', 'page_count' => 416, 'quantity' => 2, 'available' => 2, 'shelf_no' => 'B-02', 'description' => 'Modern fizik ve mistisizm.'],
            ['title' => 'Çalıkuşu', 'author' => 'Reşat Nuri Güntekin', 'isbn' => '978-975-10-0019-9', 'category_id' => 1, 'publisher' => 'İnkılap Kitabevi', 'page_count' => 520, 'quantity' => 4, 'available' => 4, 'shelf_no' => 'A-09', 'description' => 'Türk edebiyatının sevilen romanı.'],
            ['title' => 'Devlet', 'author' => 'Platon', 'isbn' => '978-975-10-0020-0', 'category_id' => 6, 'publisher' => 'İş Bankası Kültür Yayınları', 'page_count' => 390, 'quantity' => 2, 'available' => 2, 'shelf_no' => 'E-02', 'description' => 'Felsefenin temel taşlarından biri.'],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Sample loans
        Loan::create(['user_id' => 2, 'book_id' => 1, 'loan_date' => now()->subDays(10), 'due_date' => now()->addDays(4), 'status' => 'active']);
        Loan::create(['user_id' => 2, 'book_id' => 5, 'loan_date' => now()->subDays(20), 'due_date' => now()->subDays(6), 'status' => 'active']); // Overdue
        Loan::create(['user_id' => 3, 'book_id' => 2, 'loan_date' => now()->subDays(5), 'due_date' => now()->addDays(9), 'status' => 'active']);
        Loan::create(['user_id' => 4, 'book_id' => 8, 'loan_date' => now()->subDays(30), 'due_date' => now()->subDays(16), 'return_date' => now()->subDays(14), 'status' => 'returned']);
        Loan::create(['user_id' => 5, 'book_id' => 9, 'loan_date' => now()->subDays(7), 'due_date' => now()->addDays(7), 'status' => 'active']);

        // Update available count for loaned books
        Book::find(1)->update(['available' => 2]);
        Book::find(5)->update(['available' => 1]);
        Book::find(2)->update(['available' => 4]);
        Book::find(9)->update(['available' => 2]);
    }
}
