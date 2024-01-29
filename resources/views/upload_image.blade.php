<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Pet</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: calc(100% - 16px);
        }

        button:hover {
            background-color: #45a049;
        }

        #response {
            margin-top: 20px;
        }

        .back-button {
            background-color: #ddd;
            color: #333;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: calc(100% - 16px);
            margin-top: 10px;
        }

        .back-button:hover {
            background-color: #ccc;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Create Pet</h1>

    <form id="createPetForm" enctype="multipart/form-data">
        <label for="petId">Pet ID:</label>
        <input type="number" name="petId" required>
        <br>
        <label for="additionalMetadata">Additional Metadata:</label>
        <input type="text" name="additionalMetadata" required>
        <br>
        <label for="foto">Foto:</label>
        <input type="file" name="foto" accept="image/*" required>
        <br>

        <button type="button" onclick="createPet()">Create Pet</button>
        <br>
        <br>
    </form>

    <a href="/" class="back-button">Back</a>

    <div id="response"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function createPet() {
        const petId = document.querySelector('input[name="petId"]').value;
        const additionalMetadata = document.querySelector('input[name="additionalMetadata"]').value;
        const foto = document.querySelector('input[name="foto"]').files[0];

        const formData = new FormData();
        formData.append('petId', petId);
        formData.append('additionalMetadata', additionalMetadata);
        formData.append('file', foto);

        axios.post('/api/pets/upload-image', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
            .then(response => {
                console.log(response.status);
                console.log(response.data);

                const responseDiv = document.getElementById('response');
                responseDiv.innerHTML = `<p>Status: ${response.status}</p><pre>${JSON.stringify(response.data, null, 2)}</pre>`;
            })
            .catch(error => {
                console.error(error.response.data);
                const responseDiv = document.getElementById('response');
                responseDiv.innerHTML = `<p>Error: ${error.response.status}</p><pre>${JSON.stringify(error.response.data, null, 2)}</pre>`;
            });
    }
</script>
</body>
</html>
