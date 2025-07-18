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

<body class="overflow-hidden bg-cover bg-no-repeat bg-left min-h-screen"
    style="background-image: url('./assets/background_3.png');">
    <div class="absolute top-0 left-0 w-full h-full bg-black md:hidden opacity-20"></div>
    <a href="/">
        <img id="logo-support" src="./assets/logo.png" class="absolute top-[30px] left-[60px] w-[160px] hidden md:block"
            alt="ClayMe! Logo">
    </a>
    <img id="logo-support" src="./assets/background_3_Support.png"
        class="absolute bottom-0 left-0 w-[500px] hidden md:block" alt="ClayMe! Logo">
    <div id="frame" class="w-full md:w-1/2 h-[670px] top-1/2 absolute right-0 top-0"
        style="transform: translateY(-50%);">
        <div class="w-[190px] h-[471.4px] md:w-[210px] md:h-[520px] absolute md:left-[270px] md:top-[36px] left-[51px] top-[62px]"
            id="photo-strip">
            <div
                class="w-[190px] h-[471.4px] md:w-[210px] md:h-[520px] flex flex-col items-center justify-center gap-[1px] md:gap-1 absolute">
                <img src="" id="img1" crossOrigin="anonymous" style="transform: scaleX(-1);"
                    class="w-[180px] h-[132px] md:w-[195px] md:h-[142.5px]" alt="">
                <img src="" id="img2" crossOrigin="anonymous" style="transform: scaleX(-1);"
                    class="w-[180px] h-[132px] md:w-[195px] md:h-[142.5px]" alt="">
                <img src="" id="img3" crossOrigin="anonymous" style="transform: scaleX(-1);"
                    class="w-[180px] h-[132px] md:w-[195px] md:h-[142.5px]" alt="">
            </div>
            <img id="strip" src="./assets/photostripPink.png"
                class="absolute w-[192px] h-[486.4px] md:w-[210px] md:h-[533px] -left-[0.6px]" alt="">
        </div>
        <div class="h-[250px] absolute right-[63px] top-[195px] flex flex-col items-center justify-center gap-4">
            <img id="pink" src="./assets/lovePink.png" class="cursor-pointer transition-all w-[47px] hover:w-[50px]"
                alt="">
            <img id="ungu" src="./assets/loveUngu.png"
                class="transform -translate-y-[10px] cursor-pointer transition-all w-[47px] hover:w-[50px]" alt="">
            <img id="kuning" src="./assets/loveKuning.png"
                class="transform -translate-y-[25px] cursor-pointer transition-all w-[47px] hover:w-[50px]" alt="">
            <img id="putih" src="./assets/lovePutih.png"
                class="transform -translate-y-[40px] cursor-pointer transition-all w-[47px] hover:w-[50px]" alt="">
        </div>
        <div
            class="w-11/12 h-[50px] flex justify-center items-center gap-5 absolute bottom-[55px] md:bottom-[35px] left-[20px] md:left-[45px]">
            <img id="emailButton" src="./assets/buttonEmail.png"
                class="w-[115px] md:w-[145px] cursor-pointer transition-all hover:w-[160px]" alt="">
            <a id="download">
                <img src="./assets/buttonDownload.png" class="w-[145px] cursor-pointer transition-all hover:w-[160px]"
                    alt="">
            </a>
            <a href="./photo.php">
                <img src=" ./assets/buttonRetake.png" class="w-[145px] cursor-pointer transition-all hover:w-[160px]"
                    alt="">
            </a>
        </div>
    </div>

    <div class="flex flex-col items-center justify-center w-screen bg-cover bg-no-repeat bg-center min-h-screen"
        style="background-image: url('./assets/background_2.png'); display: none;" id="loading">
        <img src="./assets/maskot.png" class="animate-bounce w-[250px]" alt="">
        <img src="./assets/processing.png" class="w-[200px]" alt="">
    </div>

    <script>
        img1.src = sessionStorage.getItem('img1');
        img2.src = sessionStorage.getItem('img2');
        img3.src = sessionStorage.getItem('img3');

        const downloadLink = document.getElementById('download');
        const emailButton = document.getElementById('emailButton');

        downloadLink.addEventListener('click', function (e) {
            e.preventDefault();

            html2canvas(document.getElementById("photo-strip"), {
                useCORS: true,
                allowTaint: false,
                backgroundColor: null,
                scale: 5
            }).then((canvas) => {
                const imageUrl = canvas.toDataURL('image/png');
                const tempLink = document.createElement('a');
                tempLink.href = imageUrl;
                tempLink.download = 'photostrip_ClayMe_' + Date.now() + '.png';
                tempLink.click();
            }).catch(err => {
                console.error("Canvas download error:", err);
            });
        });

        emailButton.addEventListener('click', function (e) {
            e.preventDefault();

            const photostrip = document.getElementById('photo-strip');

            const name = prompt("Please enter your name:", "Your Name");
            const email = prompt("Please enter your email:", "Your Email");

            if (email.indexOf('@') === -1 || email.indexOf('.') === -1) {
                alert("Please enter a valid email address.");
                document.getElementById('loading').style.display = 'none';
                document.getElementById('frame').classList.remove('hidden');
                document.getElementById('logo-support').classList.remove('md:block');
                return;
            }

            if (!name || !email) {
                alert("Name and email are required to send the photo strip.");
                document.getElementById('loading').style.display = 'none';
                document.getElementById('frame').classList.remove('hidden');
                document.getElementById('logo-support').classList.remove('md:block');
                return;
            }

            html2canvas(photostrip, {
                useCORS: true,
                allowTaint: false,
                backgroundColor: null,
                scale: 5
            }).then((canvas) => {
                document.getElementById('loading').style.display = 'flex';
                document.getElementById('frame').classList.add('hidden');
                document.getElementById('logo-support').classList.remove('md:block');

                const imageData = canvas.toDataURL('image/png');

                fetch('send_email.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'imageData=' + encodeURIComponent(imageData) +
                        '&name=' + encodeURIComponent(name) +
                        '&email=' + encodeURIComponent(email)
                })
                    .then(response => response.text())
                    .then(result => {
                        document.getElementById('loading').style.display = 'none';
                        document.getElementById('frame').classList.remove('hidden');
                        document.getElementById('logo-support').classList.add('md:block');
                        alert('Email sent successfully!');
                    })
                    .catch(error => {
                        alert('Failed to send email.');
                    });
            }).catch(err => {
                alert('Failed to capture image for email.');
            });
        });

        pinkStrip = document.getElementById('pink');
        unguStrip = document.getElementById('ungu');
        kuningStrip = document.getElementById('kuning');
        putihStrip = document.getElementById('putih');
        strip = document.getElementById('strip');

        pinkStrip.addEventListener('click', function () {
            strip.src = './assets/photostripPink.png';
        });
        unguStrip.addEventListener('click', function () {
            strip.src = './assets/photostripBiru.png';
        });
        kuningStrip.addEventListener('click', function () {
            strip.src = './assets/photostripKuning.png';
        });
        putihStrip.addEventListener('click', function () {
            strip.src = './assets/photostripPutih.png';
        });
    </script>
</body>

</html>