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

<form id="createPetForm">
    <label for="name">Name:</label>
    <label>
        <input type="text" name="name" required>
    </label>
    <br>
    <label for="category">Category:</label>
    <div>
        <label for="categoryId">ID:</label>
        <input type="number" name="category[id]" required>

        <label for="categoryName">Name:</label>
        <input type="text" name="category[name]" required>
    </div>
    <br>
    <label for="photoUrls">Photo URLs:</label>
    <label>
        <input type="text" name="photoUrls" required>
    </label>
    <br>

    <label for="tags">Tags:</label>
    <div>
        <label for="tagsId">ID:</label>
        <input type="number" name="tags[id]" required>

        <label for="tagsName">Name:</label>
        <input type="text" name="tags[name]" required>
    </div>
    <br>
    <label for="status">Status:</label>
    <label>
        <select name="status">
            <option value="available">Available</option>
            <option value="pending">Pending</option>
            <option value="sold">Sold</option>
        </select>
    </label>
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

        const name = document.querySelector('input[name="name"]').value;
        const photoUrls = document.querySelector('input[name="photoUrls"]').value.split(',');
        const status = document.querySelector('select[name="status"]').value;
        const categoryId = document.querySelector('input[name="category[id]"]').value;
        const categoryName = document.querySelector('input[name="category[name]"]').value;
        const tagId = document.querySelector('input[name="tags[id]"]').value;
        const tagName = document.querySelector('input[name="tags[name]"]').value;

        const category = {
            id: categoryId,
            name: categoryName
        };

        const tag = [{
            id: tagId,
            name: tagName
        }];

        axios.post('/api/pets/store', {
            name: name,
            category: category,
            photoUrls: photoUrls,
            status: status,
            tags: tag
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
