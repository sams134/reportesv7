const MONTHS = [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'
];

function months(config, init,initYear) {
    
    var cfg = config || {};
    var count = cfg.count || 12;
    var section = cfg.section;
    var values = [];
    var i, value;

    for (i = (init - 1); i < (count + init); ++i) {
        yearIncrease = Math.floor(i/12);
        value = MONTHS[Math.ceil(i) % 12]+"'"+(initYear+yearIncrease);                
        values.push(value.substring(0, section));
    }

    return values;
}

function getDataWeights(animal_id) {

    fetch('/animals/getWeights/' + animal_id)
        .then((res) => res.json())
        .then((datos) => {
            if (datos) {
                        console.log(datos);
                    console.log(animal_id);
                    
                    var ctx = document.getElementById('myChart');
                    let chartStatus = Chart.getChart("myChart");
                    if (chartStatus != undefined) {
                        chartStatus.destroy();
                    }
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: months({ count: datos.range }, datos.init,datos.firstYear),
                            datasets: [{
                                label: 'Grafico de pesos mensuales',
                                data: datos.weights,
                                borderColor: 'rgb(43, 107, 204)',
                                pointStyle: 'circle',
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                //segment: {
                                //    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(192,75,75)'),
                                //    borderDash: ctx => skipped(ctx, [6, 6]),
                            // },
                                spanGaps: true
                            }]
                        },
                        options: genericOptions
                    });
                    }
            
        });
}

const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
const down = (ctx, value) => ctx.p0.parsed.y > ctx.p1.parsed.y ? value : undefined;

const genericOptions = {
    fill: false,
    interaction: {
        intersect: false
    },
    radius: 0,
};

var id_animal = document.querySelector("#id_animal").value;
console.log("id_animal:"+id_animal);
getDataWeights(id_animal);

Livewire.on('redraw', function(){
    id_animal = document.querySelector("#id_animal").value;
    console.log("redibujando:"+id_animal);
 
    getDataWeights(id_animal);
});