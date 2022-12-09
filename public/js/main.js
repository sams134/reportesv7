const table = document.querySelector("#colorsTable");
if (table)
    table.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove')) {
            e.preventDefault();
            Swal.fire({
                title: 'Seguro que desea eliminar este color',
                text: "Este cambio no puede ser revertido",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Borrarlo',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.parentNode.submit();
                }
            })
        }
    });

const tableOwner = document.querySelector("#ownersTable")
if (tableOwner)
    tableOwner.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove')) {
            e.preventDefault();
            Swal.fire({
                title: 'Seguro que desea eliminar este dueño',
                text: "Este cambio no puede ser revertido",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Borrarlo',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.parentNode.submit();
                }
            })
        }
    });
const tableType = document.querySelector("#typesTable")
if (tableType)
    tableType.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove')) {
            e.preventDefault();
            Swal.fire({
                title: 'Seguro que desea eliminar este tipo de animal',
                text: "Este cambio no puede ser revertido",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Borrarlo',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.parentNode.submit();
                }
            })
        }
    });

const statusTable = document.querySelector("#statusTable")
if (statusTable)
    statusTable.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove')) {
            e.preventDefault();
            Swal.fire({
                title: 'Seguro que desea eliminar este estatus?',
                text: "Este cambio no puede ser revertido",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Borrarlo',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.parentNode.submit();
                }
            })
        }
    });

function removeAnimal(id) {
    Swal.fire({
        title: 'Seguro que desea eliminar este animal?',
        text: "Este cambio no puede ser revertido",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Borrarlo',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
           Livewire.emit('removeAnimal',id);
        }
    })
}

const btn_photo_create = document.querySelector('#btn_photo_create');
if (btn_photo_create)
btn_photo_create.addEventListener('click', loadPhotoDialog_create);

function loadPhotoDialog_create(){
    
    document.querySelector("#photoDialog_create").click();
}

const photoDialog = document.querySelector("#photoDialog_create");
if (photoDialog)
photoDialog.addEventListener('change', function (){
    let reader = new FileReader();
 
    reader.onload = (e) => { 

      document.querySelector("#preview-image-before-upload").setAttribute('src', e.target.result); 
      document.querySelector("#lbl_btn_photo_create").textContent = "Cambiar fotografia"
    }
 
    reader.readAsDataURL(this.files[0]); 
})

const photoDeleteEdit = document.querySelector("#btn_photo_delete");
if (photoDeleteEdit)
photoDeleteEdit.addEventListener('click',function(){
    document.querySelector("#preview-image-before-upload").setAttribute('src', asset+'img/icons/cow.png'); 
    photoDeleteEdit.remove();
    document.querySelector('#photoDeleted').value = true;
});

const cameraBtnModal = document.querySelector("#cameraBtnModal");
if (cameraBtnModal)
cameraBtnModal.addEventListener('click',() => {
    document.querySelector("#cameraModal").click();
})

/* const test = document.querySelector("#test");
if (test)
    test.addEventListener('click',() => {
        swiperInit();
    }) */

   