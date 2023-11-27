export class productsServices{

    constructor(){
    }

    createProducts(){
        
    }
    
    getAllProducts(){
        
    }

    getOneProducts(){
        
    }

    editProducts(){

    }

    deleteProducts(){
        document.addEventListener('DOMContentLoaded', function() {
            // Asegúrate de que el elemento 'eliminate' exista
            const eliminateForm = document.getElementById('eliminate');

            if (eliminateForm) {
                eliminateForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const cod = document.getElementById('cod').value;
                    console.log(cod);
                    const formData = {
                        cod: cod,
                    };

                    fetch('api/delete.php', {
                        method: 'POST',
                        body: JSON.stringify(formData),
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert("Tarea eliminada exitosamente: " + data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            } else {
                console.error("Elemento 'eliminate' no encontrado");
            }
        });
    }
}