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
function removeCustomer(id) {
    Swal.fire({
        title: 'Seguro que desea eliminar este cliente junto con todos sus motores?',
        text: "Este cambio no puede ser revertido",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Borrarlo',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
           Livewire.emit('removeCustomer',id);
        }
    })
}

function removeMotor(id) {
    Swal.fire({
        title: 'Seguro que desea eliminar este motor y toda su informacion?',
        text: "Este cambio no puede ser revertido",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Borrarlo',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            
           Livewire.emit('removeMotor',id);
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
   
   /*  Livewire.on('closeNewContact',function (){
            
        const contactModal = bootstrap.Modal.getInstance(document.getElementById('newContact-modal'));
        contactModal.hide();    
        
    }) */
function deleteContact(key)
{
    console.log("hola");
    Swal.fire({
        title: 'Seguro que desea eliminar este contacto?',
        text: "Este cambio no puede ser revertido",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Borrarlo',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
           Livewire.emit('deleteContact',key);
        }
    })
}



const cameraBtnNameplate = document.querySelector('#cameraBtnNameplate');
if (cameraBtnNameplate)
   cameraBtnNameplate.addEventListener('click',function(){
        document.querySelector("#cameraNameplate").click();
   });
/* 
   const cameraBtnPhotoMotor1 = document.querySelector('#cameraBtnPhotoMotor1');
if (cameraBtnPhotoMotor1)
   cameraBtnPhotoMotor1.addEventListener('click',function(){
        document.querySelector("#cameraPhotoMotor1").click();
   });
   
   const cameraBtnPhotoMotor2 = document.querySelector('#cameraBtnPhotoMotor2');
   if (cameraBtnPhotoMotor2)
      cameraBtnPhotoMotor2.addEventListener('click',function(){
           document.querySelector("#cameraPhotoMotor2").click();
      });
       const cameraBtnPhotoMotor3 = document.querySelector('#cameraBtnPhotoMotor3');
if (cameraBtnPhotoMotor3)
   cameraBtnPhotoMotor3.addEventListener('click',function(){
        document.querySelector("#cameraPhotoMotor3").click();
   });

   const cameraBtnPhotoMotor4 = document.querySelector('#cameraBtnPhotoMotor4');
   if (cameraBtnPhotoMotor4)
      cameraBtnPhotoMotor4.addEventListener('click',function(){
           document.querySelector("#cameraPhotoMotor4").click();
      }); */



      function openImageModal(imageSrc) {
        // Asigna la imagen al modal
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
    
        // Abre el modal
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }
