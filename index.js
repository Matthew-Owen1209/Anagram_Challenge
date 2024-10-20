document.getElementById('upload').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('index.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            anagramResult = data.result;
            anagramCount = data.count;
            wordResult = data.word;

            // console.log('Anagram Result:', anagramResult);
            // console.log('Anagram Count:', anagramCount);
            // console.log('Word Result:', wordResult);

            document.getElementById('word-result').innerHTML = wordResult;
            document.getElementById('anagrams-result').innerHTML = anagramResult;
            document.getElementById('count-result').innerHTML = anagramCount;
        })
        .catch(error => console.error(error));
});


const fileLabel = document.getElementById('file-name');
// Get the file name
const fileInput = document.getElementById('text-file').addEventListener('change', function () {
    const nameCheck = document.getElementById('file-check').value;
    let fileName = this.files[0].name;
    let fileNameLength = fileName.length;

    if (this.files.length > 1) {
        alert("Please select only one file");
        this.value = "";
        return;
    }

    if (fileName !== nameCheck && nameCheck !== "") {
        alert("Please select the correct file");
        this.value = "";
        return;
    }

    if (fileNameLength > 10) {
        fileName = fileName.slice(0, 8) + "..";
    }

    fileLabel.innerHTML = fileName; // Sets the file name to the label
});