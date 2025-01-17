// Incarcare intregii paginii (a tuturor resurselor) si apoi lansarea functiei
window.addEventListener("load", function () {

    var paragraph = document.getElementById('optional');
    var jucarii = document.getElementsByClassName("jucarie");
    for (let jucarie of jucarii) {

        let valVarsta = parseFloat(jucarie.getElementsByClassName("varsta")[0].innerHTML)
        let cond1 = (valVarsta < 6)
        if (cond1) {
            paragraph.style.display = "block";
        }
        else {
            paragraph.style.display = "none";
        }
    }

    // Sortare dupa doua filtre pret si apoi nume
    function sorteaza(semn) {
        var produse = document.getElementsByClassName("jucarie");
        let v_produse = Array.from(produse)
        v_produse.sort(function (a, b) {
            // let pret_a = parseInt(a.getElementsByClassName("val-pret")[0].innerHTML)
            // let pret_b = parseInt(b.getElementsByClassName("val-pret")[0].innerHTML)
            if (pret_a == pret_b) {
                let pret_a = parseInt(a.getElementsByClassName("val-pret")[0].innerHTML)
                let pret_b = parseInt(b.getElementsByClassName("val-pret")[0].innerHTML)
                return semn * nume_a.localeCompare(nume_b);
            }
            return semn * (pret_a - pret_b);
        })
        console.log(v_produse)
        for (let prod of v_produse) {
            prod.parentNode.appendChild(prod)
        }
    }

        document.getElementById("sortare").onclick = function () {
            if (document.getElementById("sort-ascendent").onselect)
                {
                sorteaza(1)
            }
            else
                sorteaza(-1)

        }
    
})

