<?php
include 'header.php';
?>

<div class='container mt-2'>
    <h1 class='text-center text-dark'>
        Slikari
    </h1>
</div>

<div class='container'>
    <div class='row mt-2'>
        <div class='col-6'>
            <table class='table table-dark'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Godina rodjenja</th>
                        <th>Godina smrti</th>
                        <th>Izmeni</th>
                        <th>Obrisi</th>
                    </tr>
                </thead>
                <tbody id='slikari'>

                </tbody>
            </table>


        </div>
        <div class='col-6'>
            <h3 class="text-dark text-centar" id='naslov'>Kreiraj slikara</h3>
            <form id='forma'>
                <div class='form-group'>
                    <label for="ime">Ime</label>
                    <input required class="form-control" type="text" id="ime">
                </div>
                <div class='form-group'>
                    <label for="prezime">Prezime</label>
                    <input required class="form-control" type="text" id="prezime">
                </div>
                <div class='form-group'>
                    <label for="godina_rodjenja">Godina rodjenja</label>
                    <input required class="form-control" type="number" id="godina_rodjenja">
                </div>
                <div class='form-group'>
                    <label for="godina_smrti">Godina smrti</label>
                    <input class="form-control" type="text" id="godina_smrti">
                </div>
                <button class="btn btn-dark form-control" type="submit">Sacuvaj</button>

            </form>
            <button id="vrati" hidden class="btn btn-secondary form-control mt-2" onclick="setIndex(-1)">Vrati se
            </button>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    let slikari = [];
    let selIndex = -1;



    $(function() {
        ucitajSlikare();
        $('#forma').submit(e => {
            e.preventDefault();
            const ime = $('#ime').val();
            const prezime = $('#prezime').val();
            const godina_rodjenja = $('#godina_rodjenja').val();
            const godina_smrti = $('#godina_smrti').val();
            if (selIndex === -1) {
                $.post('server/slikar/create.php', {
                    ime,
                    prezime,
                    godina_rodjenja,
                    godina_smrti
                }).then(res => {
                    res = JSON.parse(res);
                    if (!res.status) {
                        alert(res.error);
                    } else {
                        ucitajSlikare();
                    }
                })
            } else {
                $.post('server/slikar/update.php', {
                    ime,
                    prezime,
                    godina_rodjenja,
                    godina_smrti,
                    id: slikari[selIndex].id
                }).then(res => {
                    res = JSON.parse(res);
                    if (!res.status) {
                        alert(res.error);
                    } else {
                        ucitajSlikare();
                        setIndex(-1);
                    }
                })
            }
        })
    })

    function ucitajSlikare() {
        $.getJSON('server/slikar/read.php').then(res => {

            if (!res.status) {
                alert(res.error);
                return;
            }
            setSlikari(res.kolekcija);
        })
    }

    function obrisi(id) {
        $.post('server/slikar/delete.php', {
            id
        }).then((res) => {
            res = JSON.parse(res);
            if (!res.status) {
                alert(res.error);
                return;
            }
            setSlikari(slikari.filter((e) => e.id != id));

            setIndex(-1);
        })
    }

    function setSlikari(val) {
        slikari = val;
        $('#slikari').html('');

        let index = 0;
        for (let slikar of slikari) {
            $('#slikari').append(`
                    <tr>
                        <td>${slikar.id}</td>
                        <td>${slikar.ime}</td>
                        <td>${slikar.prezime}</td>
                        <td>${slikar.godina_rodjenja}</td>
                        <td>${slikar.godina_smrti}</td>
                        <td>
                            <button class='btn btn-light form-control' onClick="setIndex(${index})" >Izmeni</button>
                        </td>
                        <td>
                            <button class='btn btn-danger form-control' onClick="obrisi(${slikar.id})">Obrisi</button>
                        </td>
                    </tr>
                `);
            index++;
        }
    }

    function setIndex(val) {
        selIndex = val
        if (selIndex === -1) {
            $('#naslov').html('Kreiraj slikara');
            $('#ime').val('');
            $('#prezime').val('');
            $('#godina_rodjenja').val('');
            $('#godina_smrti').val('');

        } else {
            $('#naslov').html('Izmeni slikara')
            $('#ime').val(slikari[selIndex].ime);
            $('#prezime').val(slikari[selIndex].prezime);
            $('#godina_rodjenja').val(slikari[selIndex].godina_rodjenja);
            $('#godina_smrti').val(slikari[selIndex].godina_smrti);
        }
        $('#vrati').attr('hidden', selIndex === -1)
    }
</script>
<?php
include 'footer.php';
?>