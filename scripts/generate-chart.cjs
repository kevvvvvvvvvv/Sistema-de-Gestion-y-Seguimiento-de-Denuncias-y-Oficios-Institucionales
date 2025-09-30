const fs = require('fs');
const { ChartJSNodeCanvas } = require('chart.js-node-canvas');


const width = 800;
const height = 400;


const outputPath = './storage/app/public/chart.png';


const renderChart = async (config) => {
  const chartJSNodeCanvas = new ChartJSNodeCanvas({ width, height });
  const image = await chartJSNodeCanvas.renderToBuffer(config);
  fs.writeFileSync(outputPath, image);
  console.log(outputPath); 
};


let data = '';
process.stdin.on('data', chunk => {
  data += chunk;
});


process.stdin.on('end', () => {
  try {
    const chartConfig = JSON.parse(data);
    renderChart(chartConfig);
  } catch (error) {
    console.error('Error parsing JSON or rendering chart:', error);
    process.exit(1); 
  }
});