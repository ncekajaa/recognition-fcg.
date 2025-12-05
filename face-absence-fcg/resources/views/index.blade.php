@extends('layouts.app')

@section('title', 'Absensi Face Recognition')

@section('styles')
<style>
    .absen-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .card {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 30px #1e1e1e;
    }

    .card-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .card-header h1 {
        color: #3B82F6;
        margin-bottom: 0.5rem;
    }

    .progress-bar-container {
        margin-bottom: 2rem;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .step {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .step::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(59, 130, 246, 0.2);
        z-index: -1;
    }

    .step:first-child::before {
        left: 50%;
    }

    .step:last-child::before {
        right: 50%;
    }

    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: rgba(59, 130, 246, 0.3);
        border: 2px solid rgba(59, 130, 246, 0.5);
        margin: 0 auto 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .step.active .step-circle {
        background: #3B82F6;
        border-color: #3B82F6;
        box-shadow: 0 0 20px #1e1e1e;
    }

    .step.completed .step-circle {
        background: #22C55E;
        border-color: #22C55E;
    }

    .step-label {
        font-size: 0.85rem;
        color: #9CA3AF;
    }

    .step.active .step-label {
        color: #3B82F6;
        font-weight: 600;
    }

    .progress-content {
        display: none;
    }

    .progress-content.active {
        display: block;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #E5E7EB;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 8px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #3B82F6;
        box-shadow: 0 0 0 30px #1e1e1e;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        width: 100%;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px #1e1e1e;
    }

    .btn-success {
        background: linear-gradient(135deg, #22C55E, #16A34A);
        color: white;
    }

    .btn-success:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px #1e1e1e;
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .camera-container {
        position: relative;
        width: 100%;
        max-width: 500px;
        margin: 0 auto 1rem;
        border-radius: 15px;
        overflow: hidden;
        border: 2px solid rgba(59, 130, 246, 0.3);
    }

    #video, #canvas {
        width: 100%;
        display: block;
    }

    #canvas {
        display: none;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-info {
        background: rgba(59, 130, 246, 0.2);
        border: 1px solid #3B82F6;
        color: #3B82F6;
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.2);
        border: 1px solid #22C55E;
        color: #22C55E;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.2);
        border: 1px solid #EF4444;
        color: #EF4444;
    }

    .loading {
        text-align: center;
        padding: 2rem;
        color: #9CA3AF;
    }

    .loading i {
        font-size: 2rem;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        100% { transform: rotate(360deg); }
    }

    .location-info {
        background: rgba(59, 130, 246, 0.1);
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
        display: none;
    }

    .location-info.active {
        display: block;
    }

    .location-info p {
        margin: 0.5rem 0;
        color: #E5E7EB;
    }
</style>
@endsection

@section('content')
<div class="absen-container">
    <div class="card">
        <div class="card-header">
            <h1><i class="fas fa-fingerprint"></i> Sistem Absensi Face Recognition</h1>
            <p style="color: #9CA3AF;">Silakan ikuti langkah-langkah untuk melakukan absensi</p>
        </div>

        <!-- Progress Bar -->
        <div class="progress-bar-container">
            <div class="progress-steps">
                <div class="step active" id="step1">
                    <div class="step-circle">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="step-label">Username & Lokasi</div>
                </div>
                <div class="step" id="step2">
                    <div class="step-circle">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="step-label">Verifikasi Wajah</div>
                </div>
            </div>
        </div>

        <!-- Step 1: Username & Location -->
        <div class="progress-content active" id="content1">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <span>Masukkan username Anda dan ambil lokasi untuk melanjutkan</span>
            </div>

            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" class="form-control" placeholder="Masukkan username Anda">
            </div>

            <button type="button" class="btn btn-primary" id="btnGetLocation">
                <i class="fas fa-map-marker-alt"></i> Ambil Lokasi & Lanjutkan
            </button>

            <div class="location-info" id="locationInfo">
                <p><strong><i class="fas fa-check-circle"></i> Lokasi Berhasil Diambil!</strong></p>
                <p id="locationText"></p>
            </div>
        </div>

        <!-- Step 2: Face Recognition -->
        <div class="progress-content" id="content2">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <span>Posisikan wajah Anda di depan kamera untuk verifikasi</span>
            </div>

            <div class="camera-container">
                <video id="video" autoplay muted playsinline></video>
                <canvas id="canvas"></canvas>
            </div>

            <div id="loadingModels" class="loading">
                <i class="fas fa-spinner"></i>
                <p>Memuat model AI...</p>
            </div>

            <button type="button" class="btn btn-success" id="btnCapture" disabled>
                <i class="fas fa-camera"></i> Ambil Foto & Verifikasi
            </button>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    let username = '';
    let latitude = null;
    let longitude = null;
    let referenceImage = null;
    let video = null;
    let canvas = null;
    let modelsLoaded = false;

    document.addEventListener('DOMContentLoaded', function() {
        // Get Location Button
        document.getElementById('btnGetLocation').addEventListener('click', getLocationAndCheckUsername);

        // Capture Button
        document.getElementById('btnCapture').addEventListener('click', captureAndVerify);
    });

    async function getLocationAndCheckUsername() {
        username = document.getElementById('username').value.trim();

        if (!username) {
            showAlert('error', 'Silakan masukkan username!');
            return;
        }

        document.getElementById('btnGetLocation').disabled = true;
        document.getElementById('btnGetLocation').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengambil lokasi...';

        // Get Location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                async function(position) {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;

                    document.getElementById('locationText').textContent = `Lat: ${latitude.toFixed(6)}, Long: ${longitude.toFixed(6)}`;
                    document.getElementById('locationInfo').classList.add('active');

                    // Check Username
                    await checkUsername();
                },
                function(error) {
                    showAlert('error', 'Gagal mengambil lokasi: ' + error.message);
                    document.getElementById('btnGetLocation').disabled = false;
                    document.getElementById('btnGetLocation').innerHTML = '<i class="fas fa-map-marker-alt"></i> Ambil Lokasi & Lanjutkan';
                }
            );
        } else {
            showAlert('error', 'Browser tidak mendukung Geolocation!');
            document.getElementById('btnGetLocation').disabled = false;
            document.getElementById('btnGetLocation').innerHTML = '<i class="fas fa-map-marker-alt"></i> Ambil Lokasi & Lanjutkan';
        }
    }

    async function checkUsername() {
        try {
            const response = await fetch('{{ route("absen.checkUsername") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ username: username })
            });

            const data = await response.json();

            if (data.status) {
                referenceImage = data.data.image;
                showAlert('success', 'Username ditemukan! Lanjut ke verifikasi wajah...');
                
                setTimeout(() => {
                    goToStep(2);
                    initCamera();
                }, 1500);
            } else {
                showAlert('error', data.message);
                document.getElementById('btnGetLocation').disabled = false;
                document.getElementById('btnGetLocation').innerHTML = '<i class="fas fa-map-marker-alt"></i> Ambil Lokasi & Lanjutkan';
            }
        } catch (error) {
            showAlert('error', 'Terjadi kesalahan: ' + error.message);
            document.getElementById('btnGetLocation').disabled = false;
            document.getElementById('btnGetLocation').innerHTML = '<i class="fas fa-map-marker-alt"></i> Ambil Lokasi & Lanjutkan';
        }
    }

    async function initCamera() {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');

        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: { ideal: 640 },
                    height: { ideal: 480 }
                } 
            });
            
            video.srcObject = stream;

            // Load Face-api models
            await loadModels();
        } catch (error) {
            showAlert('error', 'Gagal mengakses kamera: ' + error.message);
        }
    }

    async function loadModels() {
        try {
            const MODEL_URL = '/models';
            
            await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
            await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
            await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);

            modelsLoaded = true;
            document.getElementById('loadingModels').style.display = 'none';
            document.getElementById('btnCapture').disabled = false;
            
            showAlert('success', 'Model AI berhasil dimuat! Anda dapat melakukan verifikasi sekarang.');
        } catch (error) {
            showAlert('error', 'Gagal memuat model: ' + error.message);
            console.error(error);
        }
    }

    async function captureAndVerify() {
        if (!modelsLoaded) {
            showAlert('error', 'Model AI belum dimuat!');
            return;
        }

        document.getElementById('btnCapture').disabled = true;
        document.getElementById('btnCapture').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memverifikasi...';

        try {
            // Detect face from video
            const detections = await faceapi
                .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (!detections) {
                showAlert('error', 'Wajah tidak terdeteksi! Pastikan wajah Anda terlihat jelas.');
                document.getElementById('btnCapture').disabled = false;
                document.getElementById('btnCapture').innerHTML = '<i class="fas fa-camera"></i> Ambil Foto & Verifikasi';
                return;
            }

            // Load reference image
            const referenceImg = await faceapi.fetchImage(referenceImage);
            const referenceDetection = await faceapi
                .detectSingleFace(referenceImg, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (!referenceDetection) {
                showAlert('error', 'Gagal mendeteksi wajah dari foto referensi!');
                document.getElementById('btnCapture').disabled = false;
                document.getElementById('btnCapture').innerHTML = '<i class="fas fa-camera"></i> Ambil Foto & Verifikasi';
                return;
            }

            // Compare faces
            const distance = faceapi.euclideanDistance(detections.descriptor, referenceDetection.descriptor);
            const similarity = ((1 - distance) * 100).toFixed(2);

            console.log('Similarity:', similarity + '%');

            const status = similarity >= 70 ? 'success' : 'failed';

            // Submit attendance
            await submitAbsen(status);

        } catch (error) {
            showAlert('error', 'Terjadi kesalahan: ' + error.message);
            document.getElementById('btnCapture').disabled = false;
            document.getElementById('btnCapture').innerHTML = '<i class="fas fa-camera"></i> Ambil Foto & Verifikasi';
        }
    }

    async function submitAbsen(status) {
        try {
            const response = await fetch('{{ route("absen.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    username: username,
                    latitude: latitude,
                    longitude: longitude,
                    status: status
                })
            });

            const data = await response.json();

            if (data.status) {
                showAlert(status === 'success' ? 'success' : 'error', data.message);
                
                if (status === 'success') {
                    setTimeout(() => {
                        window.location.href = '{{ route("dashboard") }}';
                    }, 2000);
                } else {
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            } else {
                showAlert('error', data.message);
                document.getElementById('btnCapture').disabled = false;
                document.getElementById('btnCapture').innerHTML = '<i class="fas fa-camera"></i> Ambil Foto & Verifikasi';
            }
        } catch (error) {
            showAlert('error', 'Terjadi kesalahan: ' + error.message);
            document.getElementById('btnCapture').disabled = false;
            document.getElementById('btnCapture').innerHTML = '<i class="fas fa-camera"></i> Ambil Foto & Verifikasi';
        }
    }

    function goToStep(step) {
        // Update current step
        currentStep = step;

        // Update steps visual
        for (let i = 1; i <= 2; i++) {
            const stepEl = document.getElementById('step' + i);
            const contentEl = document.getElementById('content' + i);

            if (i < step) {
                stepEl.classList.add('completed');
                stepEl.classList.remove('active');
                contentEl.classList.remove('active');
            } else if (i === step) {
                stepEl.classList.add('active');
                stepEl.classList.remove('completed');
                contentEl.classList.add('active');
            } else {
                stepEl.classList.remove('active', 'completed');
                contentEl.classList.remove('active');
            }
        }
    }

    function showAlert(type, message) {
        const alertTypes = {
            'success': 'alert-success',
            'error': 'alert-error',
            'info': 'alert-info'
        };

        const icons = {
            'success': 'fa-check-circle',
            'error': 'fa-exclamation-circle',
            'info': 'fa-info-circle'
        };

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${alertTypes[type]}`;
        alertDiv.innerHTML = `
            <i class="fas ${icons[type]}"></i>
            <span>${message}</span>
        `;

        const container = document.querySelector('.progress-content.active');
        container.insertBefore(alertDiv, container.firstChild);

        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
</script>
@endsection