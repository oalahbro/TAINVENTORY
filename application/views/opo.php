<html>

<body>
    <input type="text" id="idPse" />
    <button id="click" onclick="showTmp()">CLICK</button>
    <div id="show"></div>

</body>
<script>
    function showTmp() {
        let k = document.getElementById('idPse').value
        const api_url = "<?= base_url() ?>login/pse?id=" + k;
        async function getapi(url) {
            const response = await fetch(url);

            var dat = await response.json();
            console.log(dat)
            show(dat);
        }
        getapi(api_url);

        function show(dat) {

            let tab =
                '';

            // Loop to access all rows
            for (let r of dat) {
                tab += `id = ${r.id}<br>
                        nama = ${r.attributes.nama}<br>`;
            }
            // Setting innerHTML as tab variable
            document.getElementById("show").innerHTML = tab;
        }
    }
</script>

</html>