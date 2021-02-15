// intéraction au clic des boutons de création de nouveaux champs d'ingrédient et d'étape d'une recette

const ingredientBtn = document.querySelector('.ingredient-btn')
const etapeBtn = document.querySelector('.etape-btn')
const ing = document.querySelectorAll('.ing')
const etapes = document.querySelectorAll('.etape')
const ingContent = document.querySelector('.ingContent')
const etContent = document.querySelector('.etContent')

let i = ing.length
let j = etapes.length

ingredientBtn.addEventListener('click', () => {
    let ingTxt = document.createElement('input')
    ingTxt.setAttribute('type', 'text')
    ingTxt.setAttribute('maxlength', '50')
    ingTxt.setAttribute('name', `ing${i}`)
    ingContent.appendChild(ingTxt)
    i++;
})

etapeBtn.addEventListener('click', () => {
    let etapeTxt = document.createElement('textarea')
    etapeTxt.setAttribute('name', `et${j}`)
    etapeTxt.setAttribute('maxlength', '500')
    etContent.appendChild(etapeTxt)
    j++;
})

