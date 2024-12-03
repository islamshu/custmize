<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GLTF Viewer</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r152/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.152.0/examples/js/loaders/GLTFLoader.js"></script>
</head>
<body>
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }
        canvas {
            display: block;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer();
            renderer.setSize(window.innerWidth, window.innerHeight);
            document.body.appendChild(renderer.domElement);

            const light = new THREE.AmbientLight(0xffffff, 1);
            scene.add(light);

            const loader = new THREE.GLTFLoader();
            loader.load(
                'https://custmize.digitalgo.net/storage/uploads/model.gltf', // Use your URL
                (gltf) => {
                    scene.add(gltf.scene);
                },
                undefined,
                (error) => {
                    console.error('Error loading GLTF model:', error);
                }
            );

            camera.position.z = 5;

            function animate() {
                requestAnimationFrame(animate);
                renderer.render(scene, camera);
            }
            animate();

            window.addEventListener('resize', () => {
                renderer.setSize(window.innerWidth, window.innerHeight);
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
            });
        });
    </script>
</body>
</html>
