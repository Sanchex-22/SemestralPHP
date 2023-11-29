export class Graficas{

    constructor(){
    }

    xCategoria(){
        fetch('http://localhost/SemestralPHP/api/products/getAll.php')
        .then(response => response.json())
        .then(data => {
            var productos = data.products;
            console.log(productos)
  
            // Obtener la cantidad de productos por categoría
            var categorias = {};
            productos.forEach(function (producto) {
                if (categorias[producto.category]) {
                    categorias[producto.category] += parseInt(producto.quantity);
                } else {
                    categorias[producto.category] = parseInt(producto.quantity);
                }
            });
            console.log(categorias)
            this.construirGraficaPastel(categorias);
        })
        .catch(error => console.error('Error al obtener datos de la API:', error));
    }

    xNombre(){
      fetch('http://localhost/SemestralPHP/api/products/getAll.php')
      .then(response => response.json())
      .then(data => {
          var productos = data.products;
          console.log(productos)

          // Obtener la cantidad de productos por categoría
          var categorias = {};
          productos.forEach(function (producto) {
              if (categorias[producto.name]) {
                  categorias[producto.name] += parseInt(producto.quantity);
              } else {
                  categorias[producto.name] = parseInt(producto.quantity);
              }
          });
          this.construirGraficaBarras(categorias);
      })
      .catch(error => console.error('Error al obtener datos de la API:', error));

    }

    construirGraficaBarras(categorias) {
        var contenedor = d3.select("#miGrafica");
        var anchoContenedor = contenedor.node().getBoundingClientRect().width;
        var alto = 300;
        var espacioEtiqueta = 20;
    
        var svg = contenedor
            .append("svg")
            .attr("width", anchoContenedor)
            .attr("height", alto + espacioEtiqueta);

        var colorScale = d3.scaleOrdinal(d3.schemeCategory10);
    
        var barras = svg.selectAll("rect")
            .data(Object.entries(categorias))
            .enter()
            .append("rect")
            .attr("x", function (d, i) {
                return i * (anchoContenedor / Object.keys(categorias).length);
            })
            .attr("y", function (d) {
                return alto - d[1];
            })
            .attr("width", anchoContenedor / Object.keys(categorias).length - 2)
            .attr("height", function (d) {
                return d[1];
            })
            .attr("fill", function (d) {
                return colorScale(d[0]);
            })
            .style("opacity", 0)  
            .transition() 
            .duration(1000)
            .style("opacity", 1);
    
        var etiquetas = svg.selectAll("text.etiqueta")
            .data(Object.entries(categorias))
            .enter()
            .append("text")
            .attr("class", "etiqueta")
            .attr("x", function (d, i) {
                return i * (anchoContenedor / Object.keys(categorias).length) + (anchoContenedor / Object.keys(categorias).length) / 2;
            })
            .attr("y", function (d) {
                return alto - d[1] - 5;
            })
            .attr("text-anchor", "middle")
            .text(function (d) {
                return d[0];
            })
            .style("fill", function (d) {
                return colorScale(d[0]);
            })
            .style("opacity", 0) 
            .transition() 
            .duration(1000)
            .style("opacity", 1);
    
        var etiquetasCantidad = svg.selectAll("text.etiqueta-cantidad")
            .data(Object.entries(categorias))
            .enter()
            .append("text")
            .attr("class", "etiqueta-cantidad")
            .attr("x", function (d, i) {
                return i * (anchoContenedor / Object.keys(categorias).length) + (anchoContenedor / Object.keys(categorias).length) / 2;
            })
            .attr("y", alto + espacioEtiqueta)
            .attr("text-anchor", "middle")
            .style("fill", function (d) {
                return colorScale(d[0]);
            })
            .text(function (d) {
                return d[1];
            })
            .style("opacity", 0)
            .transition()
            .duration(1000)
            .style("opacity", 1);
    }
    
    construirGraficaPastel(categorias) {
        var width = 200,
            height = 200,
            radius = Math.min(width, height) / 2;
    
        var color = d3.scaleOrdinal()
            .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);
    
        var arc = d3.arc()
            .outerRadius(radius - 10)
            .innerRadius(radius - 70);
    
        var pie = d3.pie()
            .sort(null)
            .value(function (d) { return d.value; });
    
        var svg = d3.select("#miGraficaPastel").append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");
    
        var datosPastel = pie(Object.entries(categorias).map(function (entry) {
            return { key: entry[0], value: entry[1] };
        }));
    
        var path = svg.selectAll("path")
            .data(datosPastel)
            .enter().append("path")
            .attr("fill", function (d) { return color(d.data.key); })
            .transition()
            .duration(1000)
            .attrTween("d", function (d) {
                var interpolate = d3.interpolate({ startAngle: 0, endAngle: 0 }, d);
                return function (t) {
                    return arc(interpolate(t));
                };
            });
    
        var text = svg.selectAll("text")
            .data(datosPastel)
            .enter().append("text")
            .attr("transform", function (d) { return "translate(" + arc.centroid(d) + ")"; })
            .attr("dy", "0.35em")
            .attr("text-anchor", "middle")
            .text(function (d) { return d.data.key; })
            .style("opacity", 0) 
            .transition() 
            .duration(1000) 
            .style("opacity", 1);
    }
    
    
}