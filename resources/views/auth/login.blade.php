@extends('layouts.app')

@section('content')
<style>
    .auth-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f5f5 0%, #fafafa 100%);
    }
    
    .auth-card {
        background: white;
        width: 100%;
        max-width: 450px;
        padding: 50px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .auth-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .auth-header h1 {
        font-size: 28px;
        color: #1a1a1a;
        margin-bottom: 10px;
    }
    
    .auth-header p {
        color: #666;
        font-size: 14px;
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
    
    .form-group input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: #E8744D;
        box-shadow: 0 0 0 3px rgba(232, 116, 77, 0.1);
    }
    
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        font-size: 14px;
    }
    
    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .remember-me input {
        width: auto;
    }
    
    .remember-me label {
        margin: 0;
        font-weight: 400;
    }
    
    .form-options a {
        color: #E8744D;
        text-decoration: none;
    }
    
    .form-options a:hover {
        text-decoration: underline;
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
        margin-bottom: 20px;
    }
    
    .btn-submit:hover {
        background-color: #d95f35;
        box-shadow: 0 4px 12px rgba(232, 116, 77, 0.3);
    }
    
    .auth-footer {
        text-align: center;
        color: #666;
        font-size: 14px;
    }
    
    .auth-footer a {
        color: #E8744D;
        text-decoration: none;
        font-weight: 600;
    }
    
    .auth-footer a:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 480px) {
        .auth-card {
            padding: 30px 20px;
        }
        
        .auth-header h1 {
            font-size: 24px;
        }
    }
</style>

<section class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Login</h1>
            <p>Masuk ke akun Anda untuk melanjutkan</p>
        </div>
        
        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
            </div>
            
            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>
                <a href="#forgot-password">Lupa password?</a>
            </div>
            
            <button type="submit" class="btn-submit">Login</button>
        </form>
        
        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('daftar') }}">Daftar di sini</a>
        </div>
    </div>
</section>
@endsection
