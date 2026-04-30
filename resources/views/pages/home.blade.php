@extends('layouts.app')

@section('content')
<style>
    .hero {
        background: linear-gradient(135deg, #f5f5f5 0%, #fafafa 100%);
        padding: 80px 20px;
        text-align: center;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .hero-content {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .hero h1 {
        font-size: 48px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 20px;
        line-height: 1.2;
    }
    
    .hero p {
        font-size: 18px;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
    }
    
    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 14px 40px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background-color: #E8744D;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #d95f35;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(232, 116, 77, 0.3);
    }
    
    .btn-secondary {
        background-color: transparent;
        color: #1a1a1a;
        border: 2px solid #E8744D;
    }
    
    .btn-secondary:hover {
        background-color: #E8744D;
        color: white;
    }
    
    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 20px;
    }
    
    .feature-card {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        transform: translateY(-5px);
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        background-color: #E8744D;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }
    
    .feature-card h3 {
        font-size: 20px;
        color: #1a1a1a;
        margin-bottom: 15px;
    }
    
    .feature-card p {
        color: #666;
        line-height: 1.6;
    }
    
    .cta-section {
        background: linear-gradient(135deg, #E8744D 0%, #d95f35 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
        margin-top: 60px;
    }
    
    .cta-section h2 {
        font-size: 36px;
        margin-bottom: 20px;
    }
    
    .cta-section p {
        font-size: 18px;
        margin-bottom: 30px;
        opacity: 0.9;
    }
    
    .btn-light {
        background-color: white;
        color: #E8744D;
    }
    
    .btn-light:hover {
        background-color: #f5f5f5;
    }
    
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 36px;
        }
        
        .hero p {
            font-size: 16px;
        }
        
        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .hero-buttons .btn {
            width: 100%;
            max-width: 300px;
        }
    }
</style>

<section class="hero">
    <div class="hero-content">
        <h1>Temukan Hunian Impianmu</h1>
        <p>Sistem informasi pemondokan UNSRI memudahkan mahasiswa dalam mencari dan mengelola hunian berkualitas dengan layanan terpercaya</p>
        <div class="hero-buttons">
            <a href="{{ route('hunian.index') }}" class="btn btn-primary">Cari Hunian</a>
            <a href="{{ route('panduan') }}" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
        </div>
    </div>
</section>

<div class="container">
    <section class="features">
        <div class="feature-card">
            <div class="feature-icon">🏠</div>
            <h3>Hunian Berkualitas</h3>
            <p>Pilihan hunian yang telah terverifikasi dan sesuai dengan standar kenyamanan mahasiswa</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">📋</div>
            <h3>Pendaftaran Mudah</h3>
            <p>Proses pendaftaran yang sederhana dan transparan hanya dalam beberapa langkah saja</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">💬</div>
            <h3>Dukungan 24/7</h3>
            <p>Tim support yang siap membantu menjawab pertanyaan dan menyelesaikan masalah Anda kapan saja</p>
        </div>
    </section>
</div>

<section class="cta-section">
    <h2>Siap Mencari Hunian?</h2>
    <p>Bergabunglah dengan ribuan mahasiswa yang telah menemukan hunian impian mereka</p>
    <a href="{{ route('daftar') }}" class="btn btn-light">Daftar Sekarang</a>
</section>
@endsection
