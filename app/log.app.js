const pwd = document.querySelector('input[readonly]')
const delPwd = document.getElementById('delPwd')
const numPad = document.querySelector('.numPad')

// fonction de fisherYates pour randomiser un tableau

function fisherYatesShuffle(arr){
    for(var i =arr.length-1 ; i>0 ;i--){
        var j = Math.floor( Math.random() * (i + 1) );
        [arr[i],arr[j]]=[arr[j],arr[i]];
    }
}

// fonction de création du pad randomisé

function randomPad(){
    const pad = [0,1,2,3,4,5,6,7,8,9,'','','','','','']
    fisherYatesShuffle(pad)
    let padHTML = ''
    pad.forEach( elem => {
        padHTML = padHTML.concat(`<div class="bloc">${elem}</div>`)
    })
    numPad.innerHTML = padHTML
    // on target nos touches de pad
    const blocs = document.querySelectorAll('.bloc')

    // et on ajoute la valeur cliquée au champ password
    blocs.forEach( elem => {
        elem.addEventListener('click', () => {
            if(elem.innerText != '' && pwd.value.length < 6)
            pwd.value = pwd.value.concat(elem.innerText)
        })
    })
}

// on load un pad à chaque chargement (1er et à chaque submit)

randomPad()

// on load un nouveau pad si l'utilisateur efface sa saisie et que le champ n'est pas nul

delPwd.addEventListener('click', () => {
    if(pwd.value.length != 0){
        pwd.value = pwd.value.slice(0,-1)
        randomPad() 
    }
})