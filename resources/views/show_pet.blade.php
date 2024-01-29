<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Pet</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
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

        input {
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
    </style>
</head>
<body>
<div class="container">
    <h1>Search Pets by ID</h1>

    <form id="searchForm">
        <label for="petId">Status:</label>
        <input type="text" name="petId" required>

        <button type="button" onclick="searchPets()">Search Pets</button>
    </form>

    <div id="response"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function searchPets() {
        const petId = document.querySelector('input[name="petId"]').value;

        axios.get(`/api/pets/${petId}`)
            .then(response => {
                const responseDiv = document.getElementById('response');
                responseDiv.innerHTML = `<p>Status: ${response.status}</p><pre>${JSON.stringify(response.data, null, 2)}</pre>`;
            })
            .catch(error => {
                const responseDiv = document.getElementById('response');
                responseDiv.innerHTML = `<p>Error: ${error.response.status}</p><pre>${JSON.stringify(error.response.data, null, 2)}</pre>`;
            });
    }
</script>
</body>
</html>
