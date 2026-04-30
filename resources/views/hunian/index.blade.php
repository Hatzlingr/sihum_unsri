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
    
    .hunian-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .filter-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 40px;
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .filter-group label {
        display: block;
        margin-bottom: 8px;
        color: #1a1a1a;
        font-weight: 600;
        font-size: 14px;
    }
    
    .filter-group select,
    .filter-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
    }
    
    .filter-group input:focus,
    .filter-group select:focus {
        outline: none;
        border-color: #E8744D;
    }
    
    .hunian-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    
    .hunian-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .hunian-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        transform: translateY(-8px);
    }
    
    .hunian-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #E8744D 0%, #d95f35 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
    }
    
    .hunian-content {
        padding: 25px;
    }
    
    .hunian-name {
        font-size: 20px;
        color: #1a1a1a;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .hunian-type {
        display: inline-block;
        background-color: #E8744D;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 15px;
    }
    
    .hunian-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    
    .hunian-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
    }
    
    .hunian-price {
        font-size: 18px;
        color: #E8744D;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .btn-detail {
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
    
    .btn-detail:hover {
        background-color: #d95f35;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }
    
    .empty-state p {
        font-size: 18px;
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .filter-section {
            grid-template-columns: 1fr;
        }
        
        .hunian-grid {
            grid-template-columns: 1fr;
        }
        
        .page-header h1 {
            font-size: 28px;
        }
    }
</style>

<section class="page-header">
    <div class="page-header-content">
        <h1>Daftar Hunian</h1>
        <p>Temukan hunian yang sesuai dengan kebutuhan dan budget Anda</p>
    </div>
</section>

<section class="hunian-section">
    <div class="filter-section">
        <div class="filter-group">
            <label for="type">Tipe Hunian</label>
            <select id="type" name="type">
                <option value="">Semua Tipe</option>
                <option value="rusunawa">Rusunawa</option>
                <option value="areana">Asrama</option>
                <option value="apartemen">Apartemen</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="location">Lokasi</label>
            <select id="location" name="location">
                <option value="">Semua Lokasi</option>
                <option value="ilir-timur">Ilir Timur</option>
                <option value="ilir-barat">Ilir Barat</option>
                <option value="ulu">Ulu</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="price-range">Harga</label>
            <select id="price-range" name="price-range">
                <option value="">Semua Harga</option>
                <option value="below-500k">Rp 150.000</option>
                <option value="500k-1m">Rp 300.000</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="search">Cari Hunian</label>
            <input type="text" id="search" name="search" placeholder="Nama atau alamat hunian...">
        </div>
    </div>
    
    <div class="hunian-grid">
        <!-- Hunian Card 1 -->
        <div class="hunian-card">
            <div class="hunian-image">🏢</div>
            <div class="hunian-content">
                <div class="hunian-type">Rusunawa</div>
                <h3 class="hunian-name">Rumah Susun A</h3>
                <div class="hunian-info">
                    <div class="hunian-info-item">
                        <span>📍</span>
                        <span>Jl. Ilir Timur</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>👥</span>
                        <span>2 orang</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>📏</span>
                        <span>24 m²</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>🛏️</span>
                        <span>1 Kamar</span>
                    </div>
                </div>
                <div class="hunian-price">Rp 150.000/bulan</div>
                <a href="{{ route('hunian.show', 1) }}" class="btn-detail">Lihat Detail</a>
            </div>
        </div>
        
        <!-- Hunian Card 2 -->
        <div class="hunian-card">
            <div class="hunian-image">🏠</div>
            <div class="hunian-content">
                <div class="hunian-type">Apartemen</div>
                <h3 class="hunian-name">Apartemen B</h3>
                <div class="hunian-info">
                    <div class="hunian-info-item">
                        <span>📍</span>
                        <span>Jl. Ilir Barat</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>👥</span>
                        <span>3 orang</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>📏</span>
                        <span>35 m²</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>🛏️</span>
                        <span>2 Kamar</span>
                    </div>
                </div>
                <div class="hunian-price">Rp 300.000/bulan</div>
                <a href="{{ route('hunian.show', 2) }}" class="btn-detail">Lihat Detail</a>
            </div>
        </div>
        
        <!-- Hunian Card 3 -->
        <div class="hunian-card">
            <div class="hunian-image">🏘️</div>
            <div class="hunian-content">
                <div class="hunian-type">Asrama</div>
                <h3 class="hunian-name">Asrama C</h3>
                <div class="hunian-info">
                    <div class="hunian-info-item">
                        <span>📍</span>
                        <span>Jl. Ulu</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>👥</span>
                        <span>2 orang</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>📏</span>
                        <span>20 m²</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>🛏️</span>
                        <span>1 Kamar</span>
                    </div>
                </div>
                <div class="hunian-price">Rp 300.000/bulan</div>
                <a href="{{ route('hunian.show', 3) }}" class="btn-detail">Lihat Detail</a>
            </div>
        </div>
        
        <!-- Hunian Card 4 -->
        <div class="hunian-card">
            <div class="hunian-image">🏢</div>
            <div class="hunian-content">
                <div class="hunian-type">Rusunawa</div>
                <h3 class="hunian-name">Rumah Susun D</h3>
                <div class="hunian-info">
                    <div class="hunian-info-item">
                        <span>📍</span>
                        <span>Jl. Ilir Timur</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>👥</span>
                        <span>2 orang</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>📏</span>
                        <span>25 m²</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>🛏️</span>
                        <span>1 Kamar</span>
                    </div>
                </div>
                <div class="hunian-price">Rp 300.000/bulan</div>
                <a href="{{ route('hunian.show', 4) }}" class="btn-detail">Lihat Detail</a>
            </div>
        </div>
        
        <!-- Hunian Card 5 -->
        <div class="hunian-card">
            <div class="hunian-image">🏠</div>
            <div class="hunian-content">
                <div class="hunian-type">Apartemen</div>
                <h3 class="hunian-name">Apartemen E</h3>
                <div class="hunian-info">
                    <div class="hunian-info-item">
                        <span>📍</span>
                        <span>Jl. Ilir Barat</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>👥</span>
                        <span>4 orang</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>📏</span>
                        <span>45 m²</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>🛏️</span>
                        <span>2 Kamar</span>
                    </div>
                </div>
                <div class="hunian-price">Rp 300.000/bulan</div>
                <a href="{{ route('hunian.show', 5) }}" class="btn-detail">Lihat Detail</a>
            </div>
        </div>
        
        <!-- Hunian Card 6 -->
        <div class="hunian-card">
            <div class="hunian-image">🏘️</div>
            <div class="hunian-content">
                <div class="hunian-type">Asrama</div>
                <h3 class="hunian-name">Asrama F</h3>
                <div class="hunian-info">
                    <div class="hunian-info-item">
                        <span>📍</span>
                        <span>Jl. Ulu</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>👥</span>
                        <span>3 orang</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>📏</span>
                        <span>30 m²</span>
                    </div>
                    <div class="hunian-info-item">
                        <span>🛏️</span>
                        <span>2 Kamar</span>
                    </div>
                </div>
                <div class="hunian-price">Rp 300.000/bulan</div>
                <a href="{{ route('hunian.show', 6) }}" class="btn-detail">Lihat Detail</a>
            </div>
        </div>
    </div>
</section>
@endsection
