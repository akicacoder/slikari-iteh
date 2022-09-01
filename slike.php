<?php
include 'header.php';
?>

<div class='container mt-2'>
    <h1 class='text-center text-dark'>
        Umetnicka dela
    </h1>
    <div class="row mt-2">
        <div class="col-9">
            <input onchange="render()" class="form-control" type="text" id="search" placeholder="search...">
        </div>
        <div class="col-3">
            <select onchange="render()" class="form-control" id="pravci">
                <option value="0">Svi pravci</option>
            </select>
        </div>
    </div>
    <div id='podaci'>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    let slike = [];
    let pravci = [];
    let slikari = [];
    $(function() {
        $.getJSON('server/pravac/read.php').then((res => {
                if (!res.status) {
                    alert(res.error);
                    return;
                }
                pravci = res.kolekcija;
                for (let pravac of pravci) {
                    $('#pravci').append(`
                <option value="${pravac.id}"> ${pravac.naziv}</option>
                `)
                }
            }))
            .then(() => {
                return $.getJSON('server/slikar/read.php')

            }).then((res => {
                if (!res.status) {
                    alert(res.error);
                    return;
                }
                slikari = res.kolekcija;

            }))
            .then(ucitajSlike)


    })



    function ucitajSlike() {
        $.getJSON('server/slika/read.php', (res => {
            if (!res.status) {
                alert(res.error);
                return;
            }
            slike = res.kolekcija || [];
            render();
        }))
    }

    function render() {
        const search = $('#search').val();
        const pravac = Number($('#pravci').val());
        const niz = slike.filter(element => {
            return (pravac == 0 || element.pravac == pravac) && element.naziv.includes(search)
        })
        let red = 0;
        let kolona = 0;
        $('#podaci').html(`<div id='row-${red}' class='row mt-2'></div>`)
        for (let slika of niz) {
            if (kolona === 4) {
                kolona = 0;
                red++;
                $('#podaci').append(`<div id='row-${red}' class='row mt-2'></div>`)
            }
            const slikar = slikari.find(element => element.id === slika.slikar);
            $(`#row-${red}`).append(
                `
                        <div class='col-3 pt-2 bg-white'>
                            <div class="card" >
                                <img class="card-img-top" src="${slika.url}" alt="Card image cap">
                                <div class="card-body">
                                    <h6 class="card-title">Naziv: ${slika.naziv}</h6>
                                    <h6 class="card-title">Pravac: ${pravci.find(element => element.id === slika.pravac).naziv}</h6>
                                    <h6 class="card-title">Autor: ${slikar.ime} ${slikar.prezime}</h6>
                                   <b>Opis:</b>
                                    <p class="card-text">${slika.opis}</p>
                                </div>
                                <div class="card-footer ">
                                    <button class='btn btn-danger form-control' onClick="obrisi(${slika.id})">Obrisi</button>
                                </div>
                            </div>
                        </div>
                    `
            )
            kolona++;
        }

    }

    function obrisi(id) {
        id = Number(id);
        $.post('server/slika/delete.php', {
            id
        }).then(res => {
            res = JSON.parse(res);
            if (!res.status) {
                alert(res.error);
                return;
            }

            slike = slike.filter(element => element.id != id);
            render();
        })
    }
</script>

<?php
include 'footer.php';
?>