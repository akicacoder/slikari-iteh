<?php
include 'header.php';
?>

<div class='container mt-2 mb-5'>
    <h1 class='text-center text-dark'>
        Kreiraj novi Apple proizvod
    </h1>
    <div class='row mt-2 d-flex justify-content-center'>
        <div class='col-7'>
            <form id='forma'>
                <div class='form-group'>
                    <label for="naziv">Naziv</label>
                    <input required name="naziv" class="form-control" type="text" id="naziv">
                </div>
                <div class='form-group'>
                    <label for="pravac">Umetnicki pravac</label>
                    <select required name='pravac' class="form-control" id="pravac"></select>
                </div>
                <div class='form-group'>
                    <label for="slikar">Autor</label>
                    <select required name="slikar" class="form-control" id="slikar"></select>
                </div>
                <div class='form-group'>
                    <label for="slika">Slika</label>
                    <input required name="slika" class="form-control-file" type="file" id="slika">
                </div>
                <div class='form-group'>
                    <label for="opis">Opis</label>
                    <textarea required name="opis" class="form-control" type="number" id="opis"></textarea>
                </div>
                <button type="submit" class="btn btn-primary form-control">Kreiraj</button>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function() {
        ucitajOptions('server/slikar/read.php', 'slikar');
        ucitajOptions('server/pravac/read.php', 'pravac');
        $('#forma').submit(e => {

            e.preventDefault();

            const naziv = $('#naziv').val();
            const pravac = $('#pravac').val();
            const slikar = $('#slikar').val();
            const opis = $('#opis').val();
            const slika = $("#slika")[0].files[0];
            const fd = new FormData();
            fd.append("slika", slika);
            fd.append("naziv", naziv);
            fd.append("opis", opis);
            fd.append("pravac", pravac);
            fd.append("slikar", slikar);
            $.ajax({
                url: "./server/slika/create.php",
                type: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    data = JSON.parse(data);
                    if (!data.status) {
                        alert(data.error);
                    }

                },

            })
        })
    })

    function ucitajOptions(url, htmlElement) {
        $.getJSON(url).then(res => {
            if (!res.status) {
                alert(res.error);
                return;
            }
            for (let element of res.kolekcija) {
                $('#' + htmlElement).append(`
                    <option value="${element.id}">
                        ${element.naziv}
                        </option>
                `)
            }
        })
    }
</script>

<?php
include 'footer.php';
?>