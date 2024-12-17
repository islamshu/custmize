<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Model Viewer with Controls</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }
        #model-container {
            width: 100vw;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div id="model-container"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128/examples/js/controls/OrbitControls.js"></script>
    <script>
        // إعداد المشهد
        const container = document.getElementById('model-container');

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        container.appendChild(renderer.domElement);

        // إضافة الإضاءة
        const light = new THREE.HemisphereLight(0xffffff, 0x444444, 1);
        light.position.set(0, 200, 0);
        scene.add(light);

        // تحميل الموديل
        const loader = new THREE.GLTFLoader();
        const gltfURL = "{{ $product->image }}"; // ضع مسار الموديل الخاص بك هنا

        loader.load(
            gltfURL,
            (gltf) => {
                scene.add(gltf.scene); // إضافة الموديل إلى المشهد
            },
            (xhr) => {
                console.log((xhr.loaded / xhr.total * 100) + '% loaded');
            },
            (error) => {
                console.error('An error occurred loading the GLTF model:', error);
            }
        );

        // إعداد OrbitControls
        const controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true; // تشغيل التخميد لجعل الحركة سلسة
        controls.dampingFactor = 0.05;

        // موضع الكاميرا
        camera.position.set(0, 2, 5);
        controls.update();

        // تحريك المشهد (Loop Animation)
        const animate = () => {
            requestAnimationFrame(animate);
            controls.update(); // تحديث التحكمات
            renderer.render(scene, camera);
        };

        animate();

        // تغيير حجم المشهد عند تغيير نافذة المتصفح
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
</body>
</html>
