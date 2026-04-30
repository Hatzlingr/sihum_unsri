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
    
    .contact-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 40px;
    }
    
    .contact-info {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .contact-info h2 {
        font-size: 24px;
        color: #1a1a1a;
        margin-bottom: 30px;
        font-weight: 600;
    }
    
    .contact-method {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .contact-method:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .contact-method-icon {
        flex-shrink: 0;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #E8744D 0%, #d95f35 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .contact-method-content h3 {
        font-size: 16px;
        color: #1a1a1a;
        margin: 0 0 8px 0;
        font-weight: 600;
    }
    
    .contact-method-content p {
        color: #666;
        margin: 0;
        font-size: 14px;
    }
    
    .contact-method-link {
        color: #E8744D;
        text-decoration: none;
        font-weight: 600;
    }
    
    .contact-method-link:hover {
        text-decoration: underline;
    }
    
    .contact-form {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .contact-form h2 {
        font-size: 24px;
        color: #1a1a1a;
        margin-bottom: 25px;
        font-weight: 600;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #1a1a1a;
        font-weight: 600;
        font-size: 14px;
    }
    
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }
    
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #E8744D;
        box-shadow: 0 0 0 3px rgba(232, 116, 77, 0.1);
    }
    
    .form-group textarea {
        resize: vertical;
        min-height: 150px;
    }
    
    .btn-submit {
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
    
    .btn-submit:hover {
        background-color: #d95f35;
        box-shadow: 0 4px 12px rgba(232, 116, 77, 0.3);
    }
    
    .quick-contact {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 40px;
        padding-top: 40px;
        border-top: 2px solid #f0f0f0;
    }
    
    .quick-contact-card {
        background: linear-gradient(135deg, #E8744D 0%, #d95f35 100%);
        color: white;
        padding: 25px;
        border-radius: 8px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .quick-contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(232, 116, 77, 0.3);
    }
    
    .quick-contact-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }
    
    .quick-contact-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .quick-contact-value {
        font-size: 14px;
        opacity: 0.9;
    }
    
    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 28px;
        }
        
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .quick-contact {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="page-header">
    <div class="page-header-content">
        <h1>Hubungi Kami</h1>
        <p>Kami siap membantu menjawab pertanyaan dan keluhan Anda</p>
    </div>
</section>

<section class="contact-section">
    <div class="contact-grid">
        <!-- Contact Info -->
        <div class="contact-info">
            <h2>Informasi Kontak</h2>
            
            <div class="contact-method">
                <div class="contact-method-icon">📍</div>
                <div class="contact-method-content">
                    <h3>Alamat</h3>
                    <p>Jl. Raya Palembang-Prabumulih, Palembang, Sumatera Selatan 30139</p>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-method-icon">📞</div>
                <div class="contact-method-content">
                    <h3>Telepon</h3>
                    <p><a href="tel:+627117708888" class="contact-method-link">+62 711 770 8888</a></p>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-method-icon">💬</div>
                <div class="contact-method-content">
                    <h3>WhatsApp</h3>
                    <p><a href="https://wa.me/6282166688888" class="contact-method-link" target="_blank">+62 821 6668 8888</a></p>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-method-icon">✉️</div>
                <div class="contact-method-content">
                    <h3>Email</h3>
                    <p><a href="mailto:info@sihum-unsri.ac.id" class="contact-method-link">info@sihum-unsri.ac.id</a></p>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-method-icon">⏰</div>
                <div class="contact-method-content">
                    <h3>Jam Operasional</h3>
                    <p>Senin - Jumat: 08:00 - 16:00<br>Sabtu: 08:00 - 12:00<br>Minggu: Tutup</p>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="contact-form">
            <h2>Kirim Pesan</h2>
            
            <form method="POST" action="{{ route('kontak.process') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subjek</label>
                    <input type="text" id="subject" name="subject" placeholder="Subjek pesan Anda" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Nomor Telepon (opsional)</label>
                    <input type="tel" id="phone" name="phone" placeholder="Nomor telepon Anda">
                </div>
                
                <div class="form-group">
                    <label for="message">Pesan</label>
                    <textarea id="message" name="message" placeholder="Tulis pesan Anda di sini..." required></textarea>
                </div>
                
                <button type="submit" class="btn-submit">Kirim Pesan</button>
            </form>
        </div>
    </div>
    
    <!-- Quick Contact Methods -->
    <div class="quick-contact">
        <div class="quick-contact-card">
            <div class="quick-contact-icon">💬</div>
            <div class="quick-contact-title">Live Chat</div>
            <div class="quick-contact-value">Chat dengan tim kami sekarang</div>
        </div>
        
        <div class="quick-contact-card">
            <div class="quick-contact-icon">📧</div>
            <div class="quick-contact-title">Email Support</div>
            <div class="quick-contact-value">Balas dalam 24 jam</div>
        </div>
        
        <div class="quick-contact-card">
            <div class="quick-contact-icon">📱</div>
            <div class="quick-contact-title">WhatsApp</div>
            <div class="quick-contact-value">Respon cepat dan mudah</div>
        </div>
        
        <div class="quick-contact-card">
            <div class="quick-contact-icon">🕐</div>
            <div class="quick-contact-title">24/7 Support</div>
            <div class="quick-contact-value">Siap membantu Anda kapan saja</div>
        </div>
    </div>
</section>
@endsection
