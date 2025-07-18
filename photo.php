<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="icon" type="image/x-icon" href="./assets/maskot.png">
    <title>ClayMe!</title>
</head>

<body class="overflow-hidden bg-cover bg-no-repeat bg-center min-h-screen"
    style="background-image: url('./assets/background_2.png');">
    <div id="photoshoot">
        <div
            class="w-screen md:h-screen h-[75vh] flex items-center justify-center md:translate-x-[-100px] md:translate-y-[0px]">
            <div class="relative md:w-[718px] md:h-[520px] w-[310px] h-[210px] rounded-2xl">
                <!-- Video -->
                <video id="video" autoplay playsinline muted
                    class="object-cover w-full h-full rounded-2xl border-5 border-[#6D6FB4]"
                    style="transform: scaleX(-1);"></video>

                <!-- Love Animation -->
                <img id="love3" src="./assets/Love3.png" class="absolute top-1/2 left-1/2 w-[100px] md:w-[150px] hidden"
                    style="transform: translate(-50%, -50%)" alt="">
                <img id="love2" src="./assets/Love2.png" class="absolute top-1/2 left-1/2 w-[100px] md:w-[150px] hidden"
                    style="transform: translate(-50%, -50%)" alt="">
                <img id="love1" src="./assets/Love1.png" class="absolute top-1/2 left-1/2 w-[100px] md:w-[150px] hidden"
                    style="transform: translate(-50%, -50%)" alt="">

                <!-- Decorations -->
                <img src="./assets/logo.png"
                    class="absolute md:-top-[50px] -top-[30px] md:-left-[50px] -left-[40px] md:w-[165px] w-[110px] rotate-[-10deg]"
                    alt="">
                <img src="./assets/asset_1.png"
                    class="absolute -top-[40px] md:-right-[50px] -right-[40px] md:w-[152px] w-[110px]" alt="">
                <img src="./assets/asset_1.png"
                    class="absolute md:-bottom-[50px] md:-left-[50px] -bottom-[40px] -left-[40px] md:w-[152px] w-[110px]"
                    alt="">
                <img src="./assets/maskot.png"
                    class="absolute md:-bottom-[50px] -bottom-[40px] md:-right-[50px] -right-[40px] md:w-[152px] w-[110px] rotate-[10deg]"
                    alt="">

                <!-- Capture Button -->
                <img src="./assets/buttonShoot.png" id="capture"
                    class="absolute md:bottom-[50px] bottom-[-50px] left-1/2 transform cursor-pointer transition-all md:hover:w-[160px] md:w-[140px] w-[100px] md:border-0 border-2 border-[#6D6FB4] rounded-lg md:bg-transparent bg-white"
                    alt="" style="transform: translateX(-50%);">
            </div>
        </div>

        <!-- Preview Images (Desktop) -->
        <div class="w-[174px] h-[420px] absolute right-[80px] top-1/2 transform hidden md:block"
            style="transform: translateY(-50%);">
            <img src="" id="img1" style="transform: scaleX(-1);"
                class="absolute top-0 w-[174px] h-[130.5px] rounded-lg border-2 border-[#6D6FB4] bg-white" alt="">
            <img src="" id="img2" style="transform: scaleX(-1);"
                class="absolute top-[143px] w-[174px] h-[130.5px] rounded-lg border-2 border-[#6D6FB4] bg-white" alt="">
            <img src="" id="img3" style="transform: scaleX(-1);"
                class="absolute top-[286px] w-[174px] h-[130.5px] rounded-lg border-2 border-[#6D6FB4] bg-white" alt="">
            <img src="./assets/buttonFrame.png" id="frame"
                class="absolute w-[140px] top-[430px] right-[17px] cursor-pointer transition-all hover:w-[160px] hover:right-[10px] hidden"
                alt="">
        </div>

        <!-- Preview Images (Mobile) -->
        <div class="md:hidden block w-full absolute bottom-[50px]">
            <div class="flex items-center justify-center gap-2 my-4">
                <img src="" id="img4" style="transform: scaleX(-1);"
                    class="w-[114px] h-[85.5px] rounded-lg border-2 border-[#6D6FB4] bg-white" alt="">
                <img src="" id="img5" style="transform: scaleX(-1);"
                    class="w-[114px] h-[85.5px] rounded-lg border-2 border-[#6D6FB4] bg-white" alt="">
                <img src="" id="img6" style="transform: scaleX(-1);"
                    class="w-[114px] h-[85.5px] rounded-lg border-2 border-[#6D6FB4] bg-white" alt="">
            </div>
            <img src="./assets/buttonFrame.png" id="frame2"
                class="w-[140px] m-auto cursor-pointer transition-all hover:right-[10px] hidden" alt="">
        </div>
    </div>

    <!-- Loading Screen -->
    <div class="flex flex-col items-center justify-center w-screen h-screen hidden" id="loading">
        <img src="./assets/maskot.png" class="animate-bounce w-[250px]" alt="">
        <img src="./assets/processing.png" class="w-[200px]" alt="">
    </div>

    <script>
        const video = document.getElementById('video');
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => video.srcObject = stream)
            .catch(err => console.error("Gagal mengakses kamera:", err));

        const capture = document.getElementById('capture');
        const [img1, img2, img3, img4, img5, img6] = ['img1', 'img2', 'img3', 'img4', 'img5', 'img6'].map(id => document.getElementById(id));
        const [goToFrame, goToFrame2] = [document.getElementById('frame'), document.getElementById('frame2')];
        const [love1, love2, love3] = ['love1', 'love2', 'love3'].map(id => document.getElementById(id));
        let canvas1 = null, canvas2 = null, canvas3 = null;

        function captureToCanvas(canvas) {
            const ctx = canvas.getContext('2d');
            const vw = video.videoWidth, vh = video.videoHeight;
            canvas.width = 900;
            canvas.height = 1200;
            const aspect = 3 / 4;
            const vAspect = vw / vh;
            let sx = 0, sy = 0, sWidth = vw, sHeight = vh;
            if (vAspect > aspect) {
                // Video terlalu lebar → crop sisi kiri & kanan
                sWidth = vw;
                sHeight = vw * aspect;
                sx = (vw - sWidth) / 2;
                sy = 0;
            } else {
                // Video terlalu tinggi → crop atas & bawah
                sWidth = vw;
                sHeight = vw * aspect;
                sx = 0;
                sy = (vh - sHeight) / 2;
            }
            ctx.drawImage(video, sx, sy, sWidth, sHeight, 0, 0, canvas.width, canvas.height);
        }

        function triggerCapture(canvasSlot, imgA, imgB) {
            const canvas = document.createElement('canvas');
            [love3, love2, love1].forEach((el, i) => {
                setTimeout(() => {
                    if (i > 0) [love3, love2, love1][i - 1].classList.add('hidden');
                    el.classList.remove('hidden');
                }, i * 1000);
            });
            setTimeout(() => {
                love1.classList.add('hidden');
                captureToCanvas(canvas);
                imgA.src = canvas.toDataURL();
                imgB.src = canvas.toDataURL();
                capture.classList.remove('hidden');
                if (!canvas1) canvas1 = canvas;
                else if (!canvas2) canvas2 = canvas;
                else if (!canvas3) canvas3 = canvas;
                const allSet = canvas1 && canvas2 && canvas3;
                [goToFrame, goToFrame2].forEach(btn => btn.classList.toggle('hidden', !allSet));
            }, 3000);
        }

        capture.addEventListener('click', () => {
            capture.classList.add('hidden');
            if (!canvas1) triggerCapture(canvas1, img1, img4);
            else if (!canvas2) triggerCapture(canvas2, img2, img5);
            else if (!canvas3) triggerCapture(canvas3, img3, img6);
        });

        [goToFrame, goToFrame2].forEach(btn => btn.addEventListener('click', () => {
            if (canvas1 && canvas2 && canvas3) {
                sessionStorage.setItem('img1', canvas1.toDataURL());
                sessionStorage.setItem('img2', canvas2.toDataURL());
                sessionStorage.setItem('img3', canvas3.toDataURL());
            }
            document.getElementById('photoshoot').classList.add('hidden');
            document.getElementById('loading').classList.remove('hidden');
            setTimeout(() => window.location.href = './frame.php', 2000);
        }));
    </script>
</body>

</html>