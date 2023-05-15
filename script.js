function ocultar(obj, es){
    let div = document.querySelector(obj);
    if(es==1){
        div.style.display = 'flex';
    }else{
        div.style.display = 'none';
    };
};

function ulOnclick(ul){
    if(ul.style.backgroundColor == 'var(--Gold)'){
        ul.style.backgroundColor = 'var(--BigBlack)';
        ul.children[1].style.color = 'var(--Gold)';
        ul.children[2].style.color = 'var(--Gold)';
        ul.children[0].checked = false;
    }else{
        ul.style.backgroundColor = 'var(--Gold)';
        ul.children[1].style.color = 'var(--Black)';
        ul.children[2].style.color = 'var(--Black)';
        ul.children[0].checked = true;
    }
}

function ModalOpen(fun, Past, id){
    ocultar('#modal', 1);

    let modalText = document.querySelector(id);
    if(fun == 0){
        modalText.innerHTML = `
            <div class="inputEnvil" style="display: none;">
                <input type="text" name="PastFile" class="inputModal" value="`+Past+`">
            </div>
            <div class="inputEnvil">
                <label>Criar Arquivo Vazio</label>
                <input type="text" name="Filename" placeholder="Nome Do novo Arquivo" class="inputModal" minlength="1">
            </div>
            <div class="inputEnvil">
                <label for="UploadFile" class="lbM" id="labInputFile">Ou Enviar arquivo</label>
                <input type="file" name="Upload" id="UploadFile" accept="*/*">
            </div>
        `;
    }else if(fun == 1){
        modalText.innerHTML = `
            <div class="inputEnvil" style="display: none;">
                <input type="text" name="PastFile" class="inputModal" value="`+Past+`">
            </div>
            <div class="inputEnvil">
                <label>Criar Pasta Vazia</label>
                <input type="text" name="NomePast" placeholder="Nome Da Pasta" class="inputModal" minlength="1">
            </div>
        `;
    }
}

function oclModal(id, fun){
    let modal = document.querySelector(id);
    let time  = 700;
    
    modal.style.animation = (time/1000)+'s modalSumir linear';
    setTimeout(()=>{
        modal.style.animation = (time/1000)+'s modal linear';
        ocultar(id, fun);
    },time);
}

function red(page){
    window.location = page;
}

function aOnclick(linha){
    var filho = linha.querySelector('.btnsFuns');
    filho.children[0].click();
}