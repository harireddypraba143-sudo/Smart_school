<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>OCR Scanner — Smart School</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Inter',sans-serif; background:#0f172a; color:#fff; min-height:100vh; }
.header { background:linear-gradient(135deg,#667eea,#764ba2); padding:16px 20px; text-align:center; }
.header h1 { font-size:18px; font-weight:700; }
.header p { font-size:12px; opacity:0.8; margin-top:4px; }
.scan-grid { padding:16px; display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.scan-card { background:#1e293b; border-radius:16px; padding:20px 16px; text-align:center; cursor:pointer; border:2px solid transparent; transition:all 0.3s; }
.scan-card:active { transform:scale(0.95); }
.scan-card.done { border-color:#16a34a; background:#0f2a1a; }
.scan-card.processing { border-color:#f59e0b; }
.scan-card .icon { font-size:36px; margin-bottom:8px; }
.scan-card .label { font-size:13px; font-weight:600; }
.scan-card .status { font-size:11px; margin-top:6px; color:#94a3b8; }
.scan-card.done .status { color:#16a34a; }
.camera-view { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#000; z-index:100; }
.camera-view video { width:100%; height:100%; object-fit:cover; }
.camera-controls { position:absolute; bottom:0; left:0; width:100%; padding:20px; background:linear-gradient(transparent,rgba(0,0,0,0.8)); display:flex; justify-content:center; gap:20px; align-items:center; }
.btn-capture { width:70px; height:70px; border-radius:50%; border:4px solid #fff; background:rgba(255,255,255,0.2); cursor:pointer; }
.btn-capture:active { background:rgba(255,255,255,0.5); }
.btn-close { width:44px; height:44px; border-radius:50%; border:2px solid #fff; background:transparent; color:#fff; font-size:20px; cursor:pointer; }
.processing-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,0.95); z-index:200; justify-content:center; align-items:center; flex-direction:column; }
.processing-overlay.active { display:flex; }
.spinner { width:60px; height:60px; border:4px solid #334155; border-top-color:#667eea; border-radius:50%; animation:spin 1s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }
.progress-text { margin-top:16px; font-size:14px; color:#94a3b8; }
.result-preview { padding:16px; }
.result-box { background:#1e293b; border-radius:12px; padding:16px; margin-top:12px; font-size:13px; }
.result-box .field { display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #334155; }
.result-box .field:last-child { border:none; }
.result-box .field .key { color:#94a3b8; }
.result-box .field .val { color:#e2e8f0; font-weight:600; text-align:right; max-width:60%; }
.btn-send { display:block; width:100%; padding:14px; background:linear-gradient(135deg,#16a34a,#15803d); color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:pointer; margin-top:16px; }
.btn-rescan { display:block; width:100%; padding:12px; background:transparent; color:#94a3b8; border:1px solid #334155; border-radius:12px; font-size:13px; cursor:pointer; margin-top:8px; }
.connected-badge { background:#16a34a; color:#fff; padding:4px 12px; border-radius:20px; font-size:11px; display:inline-block; margin-top:6px; }
canvas { display:none; }
</style>
</head>
<body>

<div class="header">
    <h1>📸 Smart School OCR Scanner</h1>
    <p>Session: <?php echo $session_id; ?></p>
    <span class="connected-badge">🟢 Connected to Admission Form</span>
</div>

<div class="scan-grid">
    <div class="scan-card" id="card_student" onclick="startScan('student_aadhaar')">
        <div class="icon">🪪</div>
        <div class="label">Student Aadhaar</div>
        <div class="status" id="status_student">Tap to scan</div>
    </div>
    <div class="scan-card" id="card_father" onclick="startScan('father_aadhaar')">
        <div class="icon">👨</div>
        <div class="label">Father Aadhaar</div>
        <div class="status" id="status_father">Tap to scan</div>
    </div>
    <div class="scan-card" id="card_mother" onclick="startScan('mother_aadhaar')">
        <div class="icon">👩</div>
        <div class="label">Mother Aadhaar</div>
        <div class="status" id="status_mother">Tap to scan</div>
    </div>
    <div class="scan-card" id="card_bank" onclick="startScan('bank')">
        <div class="icon">🏦</div>
        <div class="label">Bank Passbook</div>
        <div class="status" id="status_bank">Tap to scan</div>
    </div>
</div>

<div id="resultPreview" class="result-preview" style="display:none;">
    <h3 style="font-size:15px;">📋 Extracted Data</h3>
    <div id="resultBox" class="result-box"></div>
    <button class="btn-send" onclick="sendData()">✅ Send to Admission Form</button>
    <button class="btn-rescan" onclick="rescan()">🔄 Re-scan</button>
</div>

<!-- Camera View -->
<div class="camera-view" id="cameraView">
    <video id="video" autoplay playsinline></video>
    <div class="camera-controls">
        <button class="btn-close" onclick="closeCamera()">✕</button>
        <button class="btn-capture" onclick="capturePhoto()"></button>
    </div>
</div>

<!-- Processing Overlay -->
<div class="processing-overlay" id="processingOverlay">
    <div class="spinner"></div>
    <div class="progress-text" id="progressText">Initializing OCR...</div>
</div>

<canvas id="canvas"></canvas>

<script>
var SESSION_ID = '<?php echo $session_id; ?>';
var BASE_URL = '<?php echo base_url(); ?>';
var currentScanType = '';
var currentParsedData = {};
var videoStream = null;

function startScan(type) {
    currentScanType = type;
    document.getElementById('resultPreview').style.display = 'none';
    openCamera();
}

function openCamera() {
    var cv = document.getElementById('cameraView');
    cv.style.display = 'block';
    navigator.mediaDevices.getUserMedia({ 
        video: { facingMode: 'environment', width: { ideal: 1920 }, height: { ideal: 1080 } }
    }).then(function(stream) {
        videoStream = stream;
        document.getElementById('video').srcObject = stream;
    }).catch(function(err) {
        alert('Camera access denied. Please allow camera permission.');
        closeCamera();
    });
}

function closeCamera() {
    document.getElementById('cameraView').style.display = 'none';
    if (videoStream) {
        videoStream.getTracks().forEach(function(t) { t.stop(); });
        videoStream = null;
    }
}

function capturePhoto() {
    var video = document.getElementById('video');
    var canvas = document.getElementById('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    closeCamera();
    processOCR(canvas.toDataURL('image/jpeg', 0.9));
}

function processOCR(imageData) {
    var overlay = document.getElementById('processingOverlay');
    overlay.classList.add('active');
    document.getElementById('progressText').textContent = 'Recognizing text...';
    
    Tesseract.recognize(imageData, 'eng+hin', {
        logger: function(m) {
            if (m.status === 'recognizing text') {
                var pct = Math.round(m.progress * 100);
                document.getElementById('progressText').textContent = 'Reading: ' + pct + '%';
            }
        }
    }).then(function(result) {
        overlay.classList.remove('active');
        var text = result.data.text;
        parseAndShow(text);
    }).catch(function(err) {
        overlay.classList.remove('active');
        alert('OCR failed: ' + err.message);
    });
}

function parseAndShow(rawText) {
    var data = {};
    if (currentScanType === 'bank') {
        data = parseBankPassbook(rawText);
    } else {
        data = parseAadhaar(rawText);
    }
    currentParsedData = data;
    
    // Show result
    var box = document.getElementById('resultBox');
    var html = '';
    for (var key in data) {
        html += '<div class="field"><span class="key">' + key + '</span><span class="val">' + (data[key] || '—') + '</span></div>';
    }
    box.innerHTML = html;
    document.getElementById('resultPreview').style.display = 'block';
}

// ═══ Aadhaar Parser ═══
function parseAadhaar(text) {
    var lines = text.split('\n').map(function(l) { return l.trim(); }).filter(function(l) { return l.length > 1; });
    var data = { name: '', dob: '', gender: '', aadhaar: '', address: '' };
    
    // Extract Aadhaar number (12 digits, possibly with spaces)
    var aadhaarMatch = text.match(/\d{4}\s?\d{4}\s?\d{4}/);
    if (aadhaarMatch) data.aadhaar = aadhaarMatch[0].replace(/\s/g, '');
    
    // Extract DOB
    var dobMatch = text.match(/(\d{2}\/\d{2}\/\d{4})/);
    if (dobMatch) data.dob = dobMatch[1];
    
    // Extract Gender
    if (/male/i.test(text) && !/female/i.test(text)) data.gender = 'male';
    else if (/female/i.test(text)) data.gender = 'female';
    
    // Extract Name (usually after "Government of India" line or before DOB)
    for (var i = 0; i < lines.length; i++) {
        var line = lines[i];
        if (/government|भारत|india|uidai|unique/i.test(line)) continue;
        if (/dob|date|birth|year|जन्म/i.test(line)) continue;
        if (/male|female|पुरुष|महिला/i.test(line)) continue;
        if (/\d{4}\s?\d{4}\s?\d{4}/.test(line)) continue;
        if (/address|पता|s\/o|d\/o|w\/o|c\/o/i.test(line)) break;
        if (line.length > 3 && line.length < 50 && /^[A-Za-z\s]+$/.test(line)) {
            data.name = line;
            break;
        }
    }
    
    // Extract Address (everything after S/O, D/O, W/O, or "Address")
    var addressStart = -1;
    for (var j = 0; j < lines.length; j++) {
        if (/address|पता|s\/o|d\/o|w\/o|c\/o/i.test(lines[j])) {
            addressStart = j;
            break;
        }
    }
    if (addressStart >= 0) {
        var addrLines = [];
        for (var k = addressStart; k < Math.min(addressStart + 5, lines.length); k++) {
            if (/\d{4}\s?\d{4}\s?\d{4}/.test(lines[k])) break;
            addrLines.push(lines[k]);
        }
        data.address = addrLines.join(', ').replace(/address\s*:?\s*/i, '');
    }
    
    return data;
}

// ═══ Bank Passbook Parser ═══
function parseBankPassbook(text) {
    var data = { bank_name: '', account_no: '', ifsc: '', branch: '' };
    
    // Account number (10-18 digits)
    var accMatch = text.match(/(?:a\/c|account|acct)[\s.:]*(\d{9,18})/i);
    if (!accMatch) accMatch = text.match(/\b(\d{11,18})\b/);
    if (accMatch) data.account_no = accMatch[1];
    
    // IFSC Code
    var ifscMatch = text.match(/(?:ifsc|ifc)[\s.:]*([A-Z]{4}0[A-Z0-9]{6})/i);
    if (!ifscMatch) ifscMatch = text.match(/\b([A-Z]{4}0[A-Z0-9]{6})\b/);
    if (ifscMatch) data.ifsc = ifscMatch[1].toUpperCase();
    
    // Bank name detection
    var banks = ['State Bank of India','SBI','HDFC','ICICI','Canara Bank','Bank of Baroda','Punjab National','Union Bank','Axis Bank','Indian Bank','Kotak','IDBI'];
    banks.forEach(function(b) {
        if (text.toUpperCase().indexOf(b.toUpperCase()) >= 0) data.bank_name = b;
    });
    
    // Branch
    var branchMatch = text.match(/(?:branch|br)[\s.:]*([A-Za-z\s]+)/i);
    if (branchMatch) data.branch = branchMatch[1].trim().substring(0, 40);
    
    return data;
}

function sendData() {
    var formData = new FormData();
    formData.append('scan_type', currentScanType);
    formData.append('scan_data', JSON.stringify(currentParsedData));
    
    fetch(BASE_URL + 'index.php/admin/receive_ocr_data/' + SESSION_ID, {
        method: 'POST',
        body: formData
    }).then(function(r) { return r.json(); })
    .then(function(res) {
        if (res.success) {
            // Mark card as done
            var typeMap = { student_aadhaar: 'student', father_aadhaar: 'father', mother_aadhaar: 'mother', bank: 'bank' };
            var cardKey = typeMap[currentScanType];
            document.getElementById('card_' + cardKey).classList.add('done');
            document.getElementById('status_' + cardKey).textContent = '✅ Sent!';
            document.getElementById('resultPreview').style.display = 'none';
        }
    }).catch(function(err) {
        alert('Failed to send. Try again.');
    });
}

function rescan() {
    document.getElementById('resultPreview').style.display = 'none';
    startScan(currentScanType);
}
</script>
</body>
</html>
