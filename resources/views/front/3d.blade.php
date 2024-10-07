<!DOCTYPE html>
<html lang="ar">

<head>
    
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلايدر الصور</title>
    <style>
        .slider {
            position: relative;
            max-width: 600px;
            margin: auto;
            overflow: hidden;
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease;
        }

        .slide {
            min-width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <div class="slider">
        <div class="slides">
            <div class="slide"><img src="image1.jpg" alt="صورة 1" style="width:100%;"></div>
            <div class="slide"><img src="image2.jpg" alt="صورة 2" style="width:100%;"></div>
            <div class="slide"><img src="image3.jpg" alt="صورة 3" style="width:100%;"></div>
            </div>
    </div>

    <script>
        let index = 0;
        const slides = document.querySelector('.slides');
        const totalSlides = document.querySelectorAll('.slide').length;

        setInterval(() => {
            index = (index + 1) % totalSlides;
            slides.style.transform = 'translateX(' + (-index * 100) + '%)';
        }, 3000); // تغيير الصورة كل 3 ثواني
    </script>

</body>

</html>
