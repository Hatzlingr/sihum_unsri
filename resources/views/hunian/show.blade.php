@extends('layouts.app')

@section('content')
<style>
    .detail-header {
        background: linear-gradient(135deg, #f5f5f5 0%, #fafafa 100%);
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .breadcrumb {
        max-width: 1200px;
        margin: 0 auto;
        font-size: 14px;
        color: #666;
    }
    
    .breadcrumb a {
        color: #E8744D;
        text-decoration: none;
    }
    
    .breadcrumb a:hover {
        text-decoration: underline;
    }
    
    .detail-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-bottom: 40px;
    }
    
    .detail-image {
        width: 100%;
        height: 400px;
        background: linear-gradient(135deg, #E8744D 0%, #d95f35 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 120px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .detail-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .hunian-header {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .hunian-header h1 {
        font-size: 32px;
        color: #1a1a1a;
        margin-bottom: 15px;
    }
    
    .hunian-type {
        display: inline-block;
        background-color: #E8744D;
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 15px;
    }
    
    .hunian-location {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
        margin-bottom: 15px;
        font-size: 16px;
    }
    
    .hunian-price-large {
        font-size: 28px;
        color: #E8744D;
        font-weight: 700;
    }
    
    .quick-info {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .quick-info h3 {
        font-size: 16px;
        color: #1a1a1a;
        margin-bottom: 20px;
        font-weight: 600;
    }
    
    .quick-info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }
    
    .quick-info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .quick-info-item .label {
        color: #666;
        flex: 1;
    }
    
    .quick-info-item .value {
        color: #1a1a1a;
        font-weight: 600;
    }
    
    .btn-register {
        width: 100%;
        padding: 14px;
        background-color: #E8744D;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-register:hover {
        background-color: #d95f35;
        box-shadow: 0 4px 12px rgba(232, 116, 77, 0.3);
    }
    
    .detail-content {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .detail-tabs {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .detail-tab {
        padding: 15px 0;
        color: #666;
        font-weight: 600;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .detail-tab:hover {
        color: #E8744D;
    }
    
    .detail-tab.active {
        color: #E8744D;
        border-bottom-color: #E8744D;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    .section-title {
        font-size: 20px;
        color: #1a1a1a;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .section-text {
        color: #666;
        line-height: 1.8;
        margin-bottom: 20px;
    }
    
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    
    .feature-item {
        background: #f5f5f5;
        padding: 15px;
        border-radius: 6px;
        text-align: center;
    }
    
    .feature-item-icon {
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .feature-item-label {
        font-size: 13px;
        color: #666;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
        
        .detail-image {
            height: 250px;
            font-size: 60px;
        }
        
        .hunian-header h1 {
            font-size: 24px;
        }
        
        .detail-tabs {
            flex-wrap: wrap;
        }
    }
</style>

<div class="detail-header">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> / 
        <a href="{{ route('hunian.index') }}">Hunian</a> / 
        <span>Detail Hunian</span>
    </div>
</div>

<section class="detail-section">
    <div class="detail-grid">
        <div class="detail-image">🏢</div>
        
        <div class="detail-info">
            <div class="hunian-header">
                <div class="hunian-type">Rusunawa</div>
                <h1>Rumah Susun Mahasiswa A</h1>
                <div class="hunian-location">
                    <span>📍</span>
                    <span>Jalan Ilir Timur No. 123, Palembang</span>
                </div>
                <div class="hunian-price-large">Rp 500.000/bulan</div>
            </div>
            
            <div class="quick-info">
                <h3>Informasi Singkat</h3>
                <div class="quick-info-item">
                    <span class="label">Kapasitas Penghuni</span>
                    <span class="value">2 orang</span>
                </div>
                <div class="quick-info-item">
                    <span class="label">Ukuran Ruangan</span>
                    <span class="value">24 m²</span>
                </div>
                <div class="quick-info-item">
                    <span class="label">Jumlah Kamar</span>
                    <span class="value">1 Kamar Tidur</span>
                </div>
                <div class="quick-info-item">
                    <span class="label">Kamar Mandi</span>
                    <span class="value">1 Kamar Mandi</span>
                </div>
                <div class="quick-info-item">
                    <span class="label">Status Ketersediaan</span>
                    <span class="value" style="color: #27ae60;">Tersedia</span>
                </div>
            </div>
            
            <button class="btn-register">Daftar Sekarang</button>
        </div>
    </div>
    
    <div class="detail-content">
        <div class="detail-tabs">
            <a href="#deskripsi" class="detail-tab active" onclick="switchTab(event, 'deskripsi')">Deskripsi</a>
            <a href="#fasilitas" class="detail-tab" onclick="switchTab(event, 'fasilitas')">Fasilitas</a>
            <a href="#peraturan" class="detail-tab" onclick="switchTab(event, 'peraturan')">Peraturan</a>
        </div>
        
        <div id="deskripsi" class="tab-content active">
            <h2 class="section-title">Deskripsi Hunian</h2>
            <p class="section-text">
                Rumah Susun Mahasiswa A adalah pilihan hunian terbaik untuk mahasiswa UNSRI dengan lokasi strategis di kawasan Ilir Timur. Fasilitas lengkap dengan harga yang terjangkau membuat hunian ini menjadi pilihan utama para mahasiswa.
            </p>
            <p class="section-text">
                Setiap unit dilengkapi dengan furniture standar, akses internet, dan keamanan 24 jam. Lokasi dekat dengan kampus, pusat perbelanjaan, dan pusat hiburan membuat hunian ini sangat nyaman untuk menjalani kehidupan sebagai mahasiswa.
            </p>
        </div>
        
        <div id="fasilitas" class="tab-content">
            <h2 class="section-title">Fasilitas</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <div class="feature-item-icon">📶</div>
                    <div class="feature-item-label">WiFi Gratis</div>
                </div>
                <div class="feature-item">
                    <div class="feature-item-icon">🛏️</div>
                    <div class="feature-item-label">Furniture Lengkap</div>
                </div>
                <div class="feature-item">
                    <div class="feature-item-icon">🔐</div>
                    <div class="feature-item-label">Keamanan 24 Jam</div>
                </div>
                <div class="feature-item">
                    <div class="feature-item-icon">🌊</div>
                    <div class="feature-item-label">Air Bersih</div>
                </div>
                <div class="feature-item">
                    <div class="feature-item-icon">⚡</div>
                    <div class="feature-item-label">Listrik Stabil</div>
                </div>
                <div class="feature-item">
                    <div class="feature-item-icon">🧹</div>
                    <div class="feature-item-label">Kebersihan Terjaga</div>
                </div>
                <div class="feature-item">
                    <div class="feature-item-icon">🚴</div>
                    <div class="feature-item-label">Tempat Parkir</div>
                </div>
                <div class="feature-item">
                    <div class="feature-item-icon">👥</div>
                    <div class="feature-item-label">Ruang Komunal</div>
                </div>
            </div>
        </div>
        
        <div id="peraturan" class="tab-content">
            <h2 class="section-title">Peraturan Hunian</h2>
            <p class="section-text">
                Berikut adalah peraturan yang harus dipatuhi oleh setiap penghuni hunian:
            </p>
            <ul style="color: #666; line-height: 1.8; margin-left: 20px;">
                <li>Dilarang membuat keributan setelah jam 22:00 hingga 06:00</li>
                <li>Menjaga kebersihan ruangan dan area umum setiap saat</li>
                <li>Tidak diperbolehkan membawa makhluk hidup/hewan peliharaan</li>
                <li>Dilarang melakukan kegiatan yang merugikan penghuni lain</li>
                <li>Pembayaran sewa harus tepat waktu setiap bulannya</li>
                <li>Melaporkan kerusakan fasilitas kepada pihak manajemen segera</li>
                <li>Mengikuti kegiatan sosial dan acara komunitas hunian</li>
            </ul>
        </div>
    </div>
</section>

<script>
function switchTab(event, tabName) {
    event.preventDefault();
    
    // Hide all tabs
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.detail-tab');
    tabButtons.forEach(btn => btn.classList.remove('active'));
    
    // Show selected tab
    document.getElementById(tabName).classList.add('active');
    event.target.classList.add('active');
}
</script>
@endsection
