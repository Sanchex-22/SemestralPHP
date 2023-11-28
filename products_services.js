export class productsServices{

    constructor(){
    }

    createProducts(formData){
        fetch('http://localhost/SemestralPHP/api/products/create.php', {
            method: 'POST',
            body: JSON.stringify(formData),

        })
        .then(response => response.text())
        .then(data => {
            alert("Tarea creada exitosamente: " + data);
            window.location.href = 'dashboard.php';
        })
        .catch(error => {
            console.error('Error:', error);
        });
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
            console.log("Tarea eliminada exitosamente: " + data);
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}