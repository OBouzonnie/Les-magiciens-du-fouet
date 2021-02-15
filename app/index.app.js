const listeRecettes = document.getElementById('listeRecettes')
const cartes = document.getElementById('cartesAnimees')

let i = 0

interval = setInterval( () => {
    if(i%2 == 0){
        let moveItem = i/2 * 4.5
        let cartesAnimees = i/2 * 352 //largeur d'une carte + deux marges
        // on marque une pause toutes les itérations impaires
        if(listeRecettes){
            listeRecettes.style.top = `-${moveItem}rem`
        }
        if(cartes){
            cartes.style.left = `-${cartesAnimees}px`
        }
    }
    i++
    // on arrete l'animation lorsque la 20e carte arrive sur la page gauche
    if(i>36){
        clearInterval(interval);
    }
}, 1500)