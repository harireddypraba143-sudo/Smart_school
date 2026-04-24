<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="theme-color" content="#0f172a">
<title>Smart School Scanner</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter',sans-serif;background:#0f172a;color:#e2e8f0;min-height:100vh;overflow-x:hidden;-webkit-tap-highlight-color:transparent}
.app{max-width:430px;margin:0 auto;min-height:100vh;position:relative}

/* Header */
.app-header{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);padding:20px 20px 28px;border-radius:0 0 28px 28px;position:relative;overflow:hidden}
.app-header::after{content:'';position:absolute;top:-40px;right:-40px;width:120px;height:120px;background:rgba(255,255,255,0.08);border-radius:50%}
.app-header::before{content:'';position:absolute;bottom:-20px;left:-20px;width:80px;height:80px;background:rgba(255,255,255,0.06);border-radius:50%}
.header-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
.app-logo{display:flex;align-items:center;gap:10px}
.app-logo .icon{width:40px;height:40px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;backdrop-filter:blur(10px)}
.app-logo h1{font-size:17px;font-weight:800;letter-spacing:-0.3px}
.badge-live{background:rgba(22,163,74,0.3);color:#4ade80;padding:4px 10px;border-radius:20px;font-size:10px;font-weight:700;display:flex;align-items:center;gap:4px}
.badge-live::before{content:'';width:6px;height:6px;background:#4ade80;border-radius:50%;animation:pulse 1.5s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:0.3}}
.session-id{font-size:11px;opacity:0.6;margin-top:2px}

/* Scan Grid */
.section-title{padding:20px 20px 12px;font-size:13px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px}
.scan-grid{padding:0 16px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px}
.scan-card{background:linear-gradient(145deg,#1e293b,#1a2332);border-radius:18px;padding:18px 10px;text-align:center;cursor:pointer;border:2px solid transparent;transition:all 0.3s cubic-bezier(.4,0,.2,1);position:relative;overflow:hidden}
.scan-card:active{transform:scale(0.93)}
.scan-card.done{border-color:#16a34a;background:linear-gradient(145deg,#0f2a1a,#132a1e)}
.scan-card.done::after{content:'✓';position:absolute;top:8px;right:8px;width:20px;height:20px;background:#16a34a;border-radius:50%;font-size:11px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
.scan-card .icon{font-size:32px;margin-bottom:8px;display:block}
.scan-card .label{font-size:11px;font-weight:700;line-height:1.3}
.scan-card .sub{font-size:9px;color:#64748b;margin-top:4px}

/* Live Camera */
.camera-view{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:#000;z-index:100}
.camera-view video{width:100%;height:100%;object-fit:cover}
.scan-frame{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:85%;max-width:340px;aspect-ratio:1.6;border:2px solid rgba(102,126,234,0.6);border-radius:16px;box-shadow:0 0 0 4000px rgba(0,0,0,0.5)}
.scan-frame::before{content:'';position:absolute;top:-2px;left:-2px;right:-2px;bottom:-2px;border-radius:16px;background:linear-gradient(90deg,#667eea,#764ba2,#667eea);background-size:200%;animation:borderScan 2s linear infinite;-webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);-webkit-mask-composite:xor;padding:2px}
@keyframes borderScan{to{background-position:200%}}
.scan-label{position:absolute;top:14%;left:50%;transform:translateX(-50%);color:#fff;font-size:14px;font-weight:700;text-shadow:0 2px 8px rgba(0,0,0,0.5);white-space:nowrap}
.cam-controls{position:absolute;bottom:0;width:100%;padding:24px 20px 40px;background:linear-gradient(transparent,rgba(0,0,0,0.85));display:flex;justify-content:center;align-items:center;gap:28px}
.btn-cap{width:72px;height:72px;border-radius:50%;border:4px solid #fff;background:rgba(255,255,255,0.15);cursor:pointer;position:relative;transition:all 0.15s}
.btn-cap:active{transform:scale(0.85);background:rgba(255,255,255,0.4)}
.btn-cap::after{content:'';position:absolute;inset:6px;background:#fff;border-radius:50%;opacity:0.3}
.btn-x{width:48px;height:48px;border-radius:50%;border:none;background:rgba(255,255,255,0.15);color:#fff;font-size:22px;cursor:pointer;backdrop-filter:blur(10px)}
.btn-flash{width:48px;height:48px;border-radius:50%;border:none;background:rgba(255,255,255,0.15);color:#fff;font-size:18px;cursor:pointer;backdrop-filter:blur(10px)}

/* Processing */
.proc-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,0.97);z-index:200;justify-content:center;align-items:center;flex-direction:column}
.proc-overlay.active{display:flex}
.proc-ring{width:80px;height:80px;border:4px solid #1e293b;border-top-color:#667eea;border-radius:50%;animation:spin 0.8s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}
.proc-pct{font-size:36px;font-weight:800;color:#667eea;margin-top:20px}
.proc-txt{font-size:13px;color:#64748b;margin-top:6px}

/* Result */
.result-page{display:none;padding:16px}
.result-card{background:#1e293b;border-radius:16px;padding:16px;margin-bottom:12px}
.result-card h4{font-size:14px;font-weight:700;margin-bottom:12px;display:flex;align-items:center;gap:8px}
.field-row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #2d3748}
.field-row:last-child{border:none}
.field-row .k{color:#64748b;font-size:12px}
.field-row .v{color:#e2e8f0;font-size:12px;font-weight:600;text-align:right;max-width:55%;word-break:break-all}
.btn-send{display:block;width:100%;padding:16px;background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;border:none;border-radius:14px;font-size:15px;font-weight:800;cursor:pointer;letter-spacing:0.3px}
.btn-send:active{transform:scale(0.97)}
.btn-retry{display:block;width:100%;padding:13px;background:transparent;color:#64748b;border:1.5px solid #334155;border-radius:14px;font-size:13px;font-weight:600;cursor:pointer;margin-top:8px}

/* Bottom Nav */
.bottom-bar{position:fixed;bottom:0;left:50%;transform:translateX(-50%);width:100%;max-width:430px;background:rgba(15,23,42,0.95);backdrop-filter:blur(20px);border-top:1px solid #1e293b;padding:10px 20px 20px;display:flex;justify-content:space-around}
.nav-item{text-align:center;font-size:10px;color:#64748b;font-weight:600;cursor:pointer}
.nav-item.active{color:#667eea}
.nav-item i{display:block;font-size:20px;margin-bottom:3px}
.content-pad{padding-bottom:90px}
canvas{display:none}
</style>
</head>
<body>
<div class="app">
<div class="app-header">
    <div class="header-top">
        <div class="app-logo"><div class="icon">📸</div><div><h1>Smart School Scanner</h1><div class="session-id"><?php echo $session_id; ?></div></div></div>
        <div class="badge-live">CONNECTED</div>
    </div>
</div>

<div class="content-pad">
<div class="section-title">📄 Document Scans</div>
<div class="scan-grid">
    <div class="scan-card" id="c_student" onclick="startScan('student_aadhaar','🪪 Student Aadhaar')"><span class="icon">🪪</span><div class="label">Student<br>Aadhaar</div><div class="sub" id="s_student">Tap to scan</div></div>
    <div class="scan-card" id="c_father" onclick="startScan('father_aadhaar','👨 Father Aadhaar')"><span class="icon">👨</span><div class="label">Father<br>Aadhaar</div><div class="sub" id="s_father">Tap to scan</div></div>
    <div class="scan-card" id="c_mother" onclick="startScan('mother_aadhaar','👩 Mother Aadhaar')"><span class="icon">👩</span><div class="label">Mother<br>Aadhaar</div><div class="sub" id="s_mother">Tap to scan</div></div>
    <div class="scan-card" id="c_bank" onclick="startScan('bank','🏦 Bank Passbook')"><span class="icon">🏦</span><div class="label">Bank<br>Passbook</div><div class="sub" id="s_bank">Tap to scan</div></div>
    <div class="scan-card" id="c_tc" onclick="startScan('tc','📜 Transfer Certificate')"><span class="icon">📜</span><div class="label">Transfer<br>Certificate</div><div class="sub" id="s_tc">Tap to scan</div></div>
    <div class="scan-card" id="c_form" onclick="startScan('admission_form','📝 Admission Form')"><span class="icon">📝</span><div class="label">Admission<br>Form</div><div class="sub" id="s_form">Tap to scan</div></div>
    <div class="scan-card" id="c_photo" onclick="startScan('student_photo','📷 Student Photo')"><span class="icon">📷</span><div class="label">Student<br>Photo</div><div class="sub" id="s_photo">Tap to take</div></div>
</div>

<div id="resultPage" class="result-page">
    <div class="result-card"><h4 id="resultTitle">📋 Extracted Data</h4><div id="resultFields"></div></div>
    <button class="btn-send" onclick="sendData()">✅ Send to Admission Form</button>
    <button class="btn-retry" onclick="rescan()">🔄 Re-scan this document</button>
</div>
</div>

<div class="bottom-bar">
    <div class="nav-item active"><i class="fa fa-camera"></i>Scanner</div>
    <div class="nav-item" onclick="window.location.reload()"><i class="fa fa-refresh"></i>Reset</div>
</div>
</div>

<!-- Camera -->
<div class="camera-view" id="camView">
    <video id="vid" autoplay playsinline muted></video>
    <div class="scan-frame"></div>
    <div class="scan-label" id="scanLabel">Position document in frame</div>
    <div class="cam-controls">
        <button class="btn-x" onclick="closeCam()">✕</button>
        <button class="btn-cap" onclick="capture()"></button>
        <button class="btn-flash" id="flashBtn" onclick="toggleFlash()"><i class="fa fa-bolt"></i></button>
        <button class="btn-flash" onclick="document.getElementById('fileUpload').click()" style="margin-left: 10px;"><i class="fa fa-image"></i></button>
    </div>
</div>

<input type="file" id="fileUpload" accept="image/*" style="display:none;" onchange="handleUpload(this)">

<!-- Processing -->
<div class="proc-overlay" id="procOvl">
    <div class="proc-ring"></div>
    <div class="proc-pct" id="procPct">0%</div>
    <div class="proc-txt" id="procTxt">Initializing OCR engine...</div>
</div>
<canvas id="cvs"></canvas>

<script>
var SID='<?php echo $session_id;?>',BASE='<?php echo base_url();?>',curType='',curLabel='',curData={},stream=null,track=null;

function startScan(type,label){curType=type;curLabel=label;document.getElementById('resultPage').style.display='none';document.getElementById('scanLabel').textContent='📷 '+label;openCam();}

function openCam(){
    document.getElementById('camView').style.display='block';
    navigator.mediaDevices.getUserMedia({video:{facingMode:'environment',width:{ideal:1920},height:{ideal:1080}}})
    .then(function(s){stream=s;track=s.getVideoTracks()[0];document.getElementById('vid').srcObject=s;})
    .catch(function(){alert('Camera access needed');closeCam();});
}

function closeCam(){document.getElementById('camView').style.display='none';if(stream){stream.getTracks().forEach(function(t){t.stop()});stream=null;track=null;}}

function toggleFlash(){if(!track)return;var caps=track.getCapabilities();if(caps.torch){var curr=track.getSettings().torch||false;track.applyConstraints({advanced:[{torch:!curr}]});}}

function capture(){
    var v=document.getElementById('vid'),c=document.getElementById('cvs');
    c.width=v.videoWidth;c.height=v.videoHeight;
    var ctx=c.getContext('2d');ctx.drawImage(v,0,0);
    closeCam();

    if (curType === 'student_photo') {
        var base64 = c.toDataURL('image/jpeg', 0.85);
        curData = { image_base64: base64 };
        document.getElementById('resultTitle').textContent='📋 '+curLabel;
        document.getElementById('resultFields').innerHTML='<img src="'+base64+'" style="width:100%; border-radius:12px; margin-top:10px;">';
        document.getElementById('resultPage').style.display='block';
        window.scrollTo({top:document.getElementById('resultPage').offsetTop,behavior:'smooth'});
        return;
    }

    // Auto-enhance: increase contrast for OCR
    try{var id=ctx.getImageData(0,0,c.width,c.height),d=id.data;for(var i=0;i<d.length;i+=4){d[i]=Math.min(255,d[i]*1.3);d[i+1]=Math.min(255,d[i+1]*1.3);d[i+2]=Math.min(255,d[i+2]*1.3);}ctx.putImageData(id,0,0);}catch(e){}
    doOCR(c.toDataURL('image/jpeg',0.92));
}

function handleUpload(input){
    if(input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            closeCam();
            if (curType === 'student_photo') {
                curData = { image_base64: e.target.result };
                document.getElementById('resultTitle').textContent='📋 '+curLabel;
                document.getElementById('resultFields').innerHTML='<img src="'+e.target.result+'" style="width:100%; border-radius:12px; margin-top:10px;">';
                document.getElementById('resultPage').style.display='block';
                window.scrollTo({top:document.getElementById('resultPage').offsetTop,behavior:'smooth'});
            } else {
                doOCR(e.target.result);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function doOCR(img){
    var o=document.getElementById('procOvl');o.classList.add('active');
    document.getElementById('procPct').textContent='0%';
    document.getElementById('procTxt').textContent='Loading OCR engine...';
    Tesseract.recognize(img,'eng+hin',{logger:function(m){
        if(m.status==='recognizing text'){var p=Math.round(m.progress*100);document.getElementById('procPct').textContent=p+'%';document.getElementById('procTxt').textContent='Reading text...';}
        else if(m.status==='loading language traineddata'){document.getElementById('procTxt').textContent='Loading language data...';}
    }}).then(function(r){o.classList.remove('active');showResult(r.data.text);}).catch(function(e){o.classList.remove('active');alert('OCR Error: '+e.message);});
}

function showResult(raw){
    if(curType==='bank') curData=parseBank(raw);
    else if(curType==='tc') curData=parseTC(raw);
    else if(curType==='admission_form') curData=parseForm(raw);
    else curData=parseAadhaar(raw);
    var h='';for(var k in curData){h+='<div class="field-row"><span class="k">'+k+'</span><span class="v">'+(curData[k]||'—')+'</span></div>';}
    document.getElementById('resultTitle').textContent='📋 '+curLabel;
    document.getElementById('resultFields').innerHTML=h;
    document.getElementById('resultPage').style.display='block';
    window.scrollTo({top:document.getElementById('resultPage').offsetTop,behavior:'smooth'});
}

function parseAadhaar(t){
    var d={name:'',dob:'',gender:'',aadhaar:'',address:''};
    var am=t.match(/\d{4}\s?\d{4}\s?\d{4}/);if(am)d.aadhaar=am[0].replace(/\s/g,'');
    var dm=t.match(/(\d{2}\/\d{2}\/\d{4})/);if(dm)d.dob=dm[1];
    if(/female/i.test(t))d.gender='female';else if(/male/i.test(t))d.gender='male';
    var lines=t.split('\n').map(function(l){return l.trim()}).filter(function(l){return l.length>2});
    for(var i=0;i<lines.length;i++){var l=lines[i];if(/government|india|uidai|unique|भारत|enrollment/i.test(l))continue;if(/dob|date|birth|जन्म|year of/i.test(l))continue;if(/male|female|पुरुष|महिला/i.test(l))continue;if(/\d{4}\s?\d{4}\s?\d{4}/.test(l))continue;if(/address|पता|s\/o|d\/o|w\/o|c\/o/i.test(l))break;if(l.length>3&&l.length<50&&/^[A-Za-z\s.]+$/.test(l)){d.name=l;break;}}
    var ai=-1;for(var j=0;j<lines.length;j++){if(/address|पता|s\/o|d\/o|w\/o|c\/o/i.test(lines[j])){ai=j;break;}}
    if(ai>=0){var al=[];for(var k=ai;k<Math.min(ai+5,lines.length);k++){if(/\d{4}\s?\d{4}\s?\d{4}/.test(lines[k]))break;al.push(lines[k]);}d.address=al.join(', ').replace(/address\s*:?\s*/i,'');}
    return d;
}

function parseBank(t){
    var d={bank_name:'',account_no:'',ifsc:'',branch:''};
    var ac=t.match(/(?:a\/c|account|acct)[\s.:]*(\d{9,18})/i);if(!ac)ac=t.match(/\b(\d{11,18})\b/);if(ac)d.account_no=ac[1];
    var ic=t.match(/(?:ifsc|ifc)[\s.:]*([A-Z]{4}0[A-Z0-9]{6})/i);if(!ic)ic=t.match(/\b([A-Z]{4}0[A-Z0-9]{6})\b/);if(ic)d.ifsc=ic[1].toUpperCase();
    ['State Bank of India','SBI','HDFC','ICICI','Canara Bank','Bank of Baroda','Punjab National','Union Bank','Axis Bank','Indian Bank','Kotak','IDBI','Andhra Bank','Indian Overseas','Central Bank','Telangana Grameena'].forEach(function(b){if(t.toUpperCase().indexOf(b.toUpperCase())>=0)d.bank_name=b;});
    var br=t.match(/(?:branch|br)[\s.:]*([A-Za-z\s]+)/i);if(br)d.branch=br[1].trim().substring(0,40);
    return d;
}

function parseTC(t){
    var d={student_name:'',father_name:'',dob:'',class_studied:'',school_name:'',date_of_leaving:'',conduct:'',reason:''};
    var nm=t.match(/(?:name|student)[\s.:]+([A-Za-z\s.]+)/i);if(nm)d.student_name=nm[1].trim().substring(0,40);
    var fm=t.match(/(?:father|parent|s\/o|d\/o)[\s.:]+([A-Za-z\s.]+)/i);if(fm)d.father_name=fm[1].trim().substring(0,40);
    var dm=t.match(/(\d{2}[\/-]\d{2}[\/-]\d{4})/);if(dm)d.dob=dm[1];
    var cm=t.match(/(?:class|standard)[\s.:]+(\S+)/i);if(cm)d.class_studied=cm[1];
    var sm=t.match(/(?:school|institution)[\s.:]+([A-Za-z\s.]+)/i);if(sm)d.school_name=sm[1].trim().substring(0,60);
    var cd=t.match(/(?:conduct|behaviour|behavior)[\s.:]+([A-Za-z]+)/i);if(cd)d.conduct=cd[1];
    var rm=t.match(/(?:reason|leaving|purpose)[\s.:]+([A-Za-z\s]+)/i);if(rm)d.reason=rm[1].trim().substring(0,40);
    return d;
}

function parseForm(t){
    var d={student_name:'',father_name:'',mother_name:'',dob:'',phone:'',address:''};
    var nm=t.match(/(?:student|name|pupil)[\s.:]+([A-Za-z\s.]+)/i);if(nm)d.student_name=nm[1].trim().substring(0,40);
    var fm=t.match(/(?:father)[\s']*(?:s)?[\s]*(?:name)?[\s.:]+([A-Za-z\s.]+)/i);if(fm)d.father_name=fm[1].trim().substring(0,40);
    var mm=t.match(/(?:mother)[\s']*(?:s)?[\s]*(?:name)?[\s.:]+([A-Za-z\s.]+)/i);if(mm)d.mother_name=mm[1].trim().substring(0,40);
    var dm=t.match(/(\d{2}[\/-]\d{2}[\/-]\d{4})/);if(dm)d.dob=dm[1];
    var pm=t.match(/(?:phone|mobile|contact)[\s.:]+(\d{10})/i);if(pm)d.phone=pm[1];
    return d;
}

function sendData(){
    var fd=new FormData();fd.append('scan_type',curType);fd.append('scan_data',JSON.stringify(curData));
    fetch(BASE+'index.php/admin/receive_ocr_data/'+SID,{method:'POST',body:fd})
    .then(function(r){return r.json()}).then(function(res){
        if(res.success){
            var map={student_aadhaar:'student',father_aadhaar:'father',mother_aadhaar:'mother',bank:'bank',tc:'tc',admission_form:'form',student_photo:'photo'};
            var ck=map[curType];
            document.getElementById('c_'+ck).classList.add('done');
            document.getElementById('s_'+ck).textContent='✅ Sent!';
            document.getElementById('resultPage').style.display='none';
            window.scrollTo({top:0,behavior:'smooth'});
        }
    }).catch(function(){alert('Send failed. Try again.');});
}

function rescan(){document.getElementById('resultPage').style.display='none';startScan(curType,curLabel);}
</script>
</body>
</html>
