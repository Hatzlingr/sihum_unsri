@extends('layouts.app')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #f5f5f5 0%, #fafafa 100%);
        padding: 40px 20px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .page-header-content {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .page-header h1 {
        font-size: 36px;
        color: #1a1a1a;
        margin-bottom: 10px;
    }
    
    .page-header p {
        color: #666;
        font-size: 16px;
    }
    
    .faq-section {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .faq-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .faq-item {
        border-bottom: 1px solid #f0f0f0;
    }
    
    .faq-item:last-child {
        border-bottom: none;
    }
    
    .faq-question {
        padding: 25px;
        background: white;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        user-select: none;
    }
    
    .faq-question:hover {
        background-color: #f9f9f9;
    }
    
    .faq-question.active {
        background-color: #f5f5f5;
    }
    
    .faq-question-text {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
    }
    
    .faq-toggle {
        font-size: 20px;
        color: #E8744D;
        transition: transform 0.3s ease;
    }
    
    .faq-item.active .faq-toggle {
        transform: rotate(180deg);
    }
    
    .faq-answer {
        padding: 0 25px;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
    }
    
    .faq-answer.show {
        padding: 0 25px 25px 25px;
        max-height: 500px;
    }
    
    .faq-answer-text {
        color: #666;
        line-height: 1.8;
        font-size: 15px;
    }
    
    .faq-category {
        margin-bottom: 40px;
    }
    
    .faq-category-title {
        font-size: 24px;
        color: #1a1a1a;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 3px solid #E8744D;
        font-weight: 600;
    }
    
    .search-box {
        margin-bottom: 30px;
    }
    
    .search-box input {
        width: 100%;
        padding: 15px 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }
    
    .search-box input:focus {
        outline: none;
        border-color: #E8744D;
        box-shadow: 0 0 0 3px rgba(232, 116, 77, 0.1);
    }
    
    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 28px;
        }
        
        .faq-question {
            padding: 20px;
        }
        
        .faq-answer.show {
            padding: 0 20px 20px 20px;
        }
    }
</style>

<section class="page-header">
    <div class="page-header-content">
        <h1>Frequently Asked Questions</h1>
        <p>Temukan jawaban atas pertanyaan umum Anda di sini</p>
    </div>
</section>

<section class="faq-section">
    <div class="search-box">
        <input type="text" id="faq-search" placeholder="Cari pertanyaan..." onkeyup="searchFAQ()">
    </div>
    
    <!-- Kategori: Pendaftaran -->
    <div class="faq-category">
        <div class="faq-category-title">📝 Pendaftaran</div>
        
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Bagaimana cara mendaftar di sistem SIHUM?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Anda dapat mendaftar dengan mengklik tombol "Daftar" di menu utama. Isi form dengan data yang valid termasuk email dan NIM Anda. Setelah itu, verifikasi email melalui link yang dikirim ke inbox Anda.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Berapa biaya untuk mendaftar?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Pendaftaran di sistem SIHUM adalah GRATIS. Kami tidak memungut biaya apapun untuk proses pendaftaran. Yang Anda bayarkan hanya biaya hunian yang disepakati dengan pemilik kos.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Apakah NIM harus verified?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Ya, NIM Anda akan diverifikasi untuk memastikan Anda adalah mahasiswa UNSRI. Sistem kami akan melakukan cross-check dengan database akademik universitas untuk validasi.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kategori: Hunian -->
    <div class="faq-category">
        <div class="faq-category-title">🏠 Hunian</div>
        
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Apa saja jenis hunian yang tersedia?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Sistem kami menyediakan berbagai jenis hunian antara lain: Rusunawa (Rumah Susun Mahasiswa), Areana, dan Apartemen. Masing-masing memiliki karakteristik dan harga yang berbeda sesuai dengan fasilitas yang ditawarkan.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Bagaimana cara mencari hunian yang sesuai?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Anda dapat menggunakan filter di halaman "Daftar Hunian" untuk menyaring berdasarkan tipe hunian, lokasi, dan range harga. Ini akan membantu Anda menemukan hunian yang sesuai dengan preferensi dan budget Anda.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Apakah semua hunian sudah terverifikasi?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Ya, semua hunian yang terdaftar di sistem SIHUM telah melalui proses verifikasi dari pihak universitas untuk memastikan standar kualitas dan keamanan yang memadai bagi mahasiswa.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kategori: Pembayaran -->
    <div class="faq-category">
        <div class="faq-category-title">💰 Pembayaran</div>
        
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Bagaimana cara membayar biaya hunian?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Metode pembayaran ditentukan oleh pemilik kos. Biasanya dapat dilakukan melalui transfer bank, e-wallet, atau pembayaran tunai. Tanyakan langsung kepada pemilik kos tentang metode pembayaran yang diterima.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Apakah ada biaya tersembunyi?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Tidak ada. Semua biaya harus dijelaskan secara transparan oleh pemilik kos sebelum Anda menandatangani kontrak. Pastikan untuk membaca detail hunian sebelum melakukan kesepakatan.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Bolehkah pembayaran dicicil?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Itu tergantung dari kebijakan pemilik kos. Beberapa pemilik mungkin bersedia melakukan pembayaran bulanan, sementara yang lain mungkin memerlukan pembayaran dimuka. Diskusikan hal ini langsung dengan pemilik kos.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kategori: Peraturan -->
    <div class="faq-category">
        <div class="faq-category-title">⚖️ Peraturan</div>
        
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Apa saja peraturan umum hunian?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Peraturan umum mencakup: menjaga kebersihan, tidak membuat keributan, tidak membawa makhluk hidup, membayar tepat waktu, dan menghormati penghuni lain. Detail peraturan spesifik dapat dilihat di halaman detail hunian masing-masing.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Bolehkah membawa tamu menginap?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Kebijakan tamu ditentukan oleh pemilik kos. Beberapa hunian mungkin mengizinkan tamu untuk menginap dengan batasan waktu tertentu. Pastikan untuk bertanya kepada pemilik kos tentang kebijakan ini.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <h3 class="faq-question-text">Apa yang boleh dan tidak boleh dipajang?</h3>
                    <span class="faq-toggle">▼</span>
                </div>
                <div class="faq-answer">
                    <p class="faq-answer-text">Anda tidak boleh menempel atau mengecat dinding tanpa izin pemilik. Anda juga tidak boleh mengubah struktur ruangan. Tanya kepada pemilik kos tentang apa yang boleh dan tidak boleh dilakukan di ruangan Anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleFAQ(element) {
    const faqItem = element.parentElement;
    const answer = faqItem.querySelector('.faq-answer');
    
    // Close all other items
    document.querySelectorAll('.faq-item').forEach(item => {
        if (item !== faqItem) {
            item.classList.remove('active');
            item.querySelector('.faq-answer').classList.remove('show');
        }
    });
    
    // Toggle current item
    faqItem.classList.toggle('active');
    answer.classList.toggle('show');
}

function searchFAQ() {
    const searchInput = document.getElementById('faq-search').value.toLowerCase();
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question-text').textContent.toLowerCase();
        const answer = item.querySelector('.faq-answer-text').textContent.toLowerCase();
        
        if (question.includes(searchInput) || answer.includes(searchInput)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
@endsection
