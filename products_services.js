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

    deleteProducts(formData){
        console.log(formData)
        fetch('http://localhost/SemestralPHP/api/products/delete.php', {
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
    }
}