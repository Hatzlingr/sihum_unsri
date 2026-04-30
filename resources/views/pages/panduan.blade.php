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
    
    .guide-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .guide-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
    }
    
    .guide-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .guide-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        transform: translateY(-8px);
    }
    
    .guide-card-header {
        background: linear-gradient(135deg, #E8744D 0%, #d95f35 100%);
        padding: 40px 20px;
        color: white;
        text-align: center;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    
    .guide-card-icon {
        font-size: 48px;
        margin-bottom: 10px;
    }
    
    .guide-card-title {
        font-size: 22px;
        font-weight: 700;
    }
    
    .guide-card-content {
        padding: 25px;
    }
    
    .guide-card-content h3 {
        font-size: 18px;
        color: #1a1a1a;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .guide-card-content p {
        color: #666;
        line-height: 1.8;
        margin-bottom: 15px;
    }
    
    .guide-steps {
        background: #f5f5f5;
        padding: 20px;
        border-radius: 6px;
        margin-top: 15px;
    }
    
    .step {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .step:last-child {
        margin-bottom: 0;
    }
    
    .step-number {
        flex-shrink: 0;
        width: 30px;
        height: 30px;
        background-color: #E8744D;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }
    
    .step-text {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
    }
    
    .btn-guide {
        width: 100%;
        padding: 12px;
        background-color: #E8744D;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    
    .btn-guide:hover {
        background-color: #d95f35;
    }
    
    .faq-info {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-top: 40px;
        border-left: 4px solid #E8744D;
    }
    
    .faq-info h3 {
        font-size: 20px;
        color: #1a1a1a;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .faq-info p {
        color: #666;
        line-height: 1.8;
    }
    
    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 28px;
        }
        
        .guide-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="page-header">
    <div class="page-header-content">
        <h1>Panduan</h1>
        <p>Panduan lengkap untuk memahami sistem pemondokan UNSRI</p>
    </div>
</section>

<section class="guide-section">
    <div class="guide-grid">
        <!-- Panduan 1: Pendaftaran -->
        <div class="guide-card">
            <div class="guide-card-header">
                <div class="guide-card-icon">📝</div>
                <div class="guide-card-title">Pendaftaran</div>
            </div>
            <div class="guide-card-content">
                <h3>Cara Mendaftar</h3>
                <p>Ikuti langkah-langkah untuk mendaftar sebagai mahasiswa yang mencari hunian.</p>
                <div class="guide-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-text">Klik tombol "Daftar" di menu utama</div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-text">Isi form dengan data yang valid (Email, NIM, Password)</div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-text">Verifikasi email melalui link yang dikirim</div>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-text">Akun Anda siap digunakan untuk mencari hunian</div>
                    </div>
                </div>
                <a href="{{ route('daftar') }}" class="btn-guide" style="margin-top: 20px;">Daftar Sekarang</a>
            </div>
        </div>
        
        <!-- Panduan 2: Informasi -->
        <div class="guide-card">
            <div class="guide-card-header">
                <div class="guide-card-icon">ℹ️</div>
                <div class="guide-card-title">Informasi</div>
            </div>
            <div class="guide-card-content">
                <h3>Temukan Hunian Terbaik</h3>
                <p>Pelajari cara mencari dan memilih hunian yang sesuai dengan kebutuhan Anda.</p>
                <div class="guide-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-text">Buka halaman "Daftar Hunian"</div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-text">Gunakan filter untuk mempersempit pilihan hunian</div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-text">Klik "Lihat Detail" untuk informasi lengkap</div>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-text">Hubungi pemilik kos atau daftar untuk bernegosiasi</div>
                    </div>
                </div>
                <a href="{{ route('hunian.index') }}" class="btn-guide" style="margin-top: 20px;">Lihat Hunian</a>
            </div>
        </div>
        
        <!-- Panduan 3: Membership -->
        <div class="guide-card">
            <div class="guide-card-header">
                <div class="guide-card-icon">👤</div>
                <div class="guide-card-title">Keanggotaan</div>
            </div>
            <div class="guide-card-content">
                <h3>Manfaat Member</h3>
                <p>Ketahui keuntungan menjadi anggota sistem pemondokan UNSRI.</p>
                <div class="guide-steps">
                    <div class="step">
                        <div class="step-number">✓</div>
                        <div class="step-text">Akses ke semua hunian yang terdaftar</div>
                    </div>
                    <div class="step">
                        <div class="step-number">✓</div>
                        <div class="step-text">Kemudahan dalam proses pendaftaran hunian</div>
                    </div>
                    <div class="step">
                        <div class="step-number">✓</div>
                        <div class="step-text">Dukungan penuh dari tim support kami</div>
                    </div>
                    <div class="step">
                        <div class="step-number">✓</div>
                        <div class="step-text">Update informasi hunian terbaru</div>
                    </div>
                </div>
                <button class="btn-guide" style="margin-top: 20px;">Pelajari Selengkapnya</button>
            </div>
        </div>
    </div>
    
    <div class="faq-info">
        <h3>Butuh Bantuan Lebih Lanjut?</h3>
        <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan lebih lanjut, silakan kunjungi halaman <a href="{{ route('faq') }}" style="color: #E8744D; text-decoration: none; font-weight: 600;">FAQ</a> kami atau hubungi tim support melalui halaman <a href="{{ route('kontak') }}" style="color: #E8744D; text-decoration: none; font-weight: 600;">Kontak</a>.</p>
    </div>
</section>
@endsection
