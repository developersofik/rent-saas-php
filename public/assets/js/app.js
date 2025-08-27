// Placeholder for future JS
document.addEventListener('DOMContentLoaded', () => {
  // Chart sample on dashboard if element exists
  const ctx1 = document.getElementById('salesChart');
  if (ctx1) {
    new Chart(ctx1, {
      type: 'bar',
      data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [
          { label: 'Gross margin', data: [12,19,11,15,17,22,19,25,23,29,32,30] },
          { label: 'Revenue', data: [20,25,18,23,28,35,30,40,38,45,48,50] }
        ]
      }
    });
  }

  // Doughnut chart for category distribution
  const ctx2 = document.getElementById('categoryChart');
  if (ctx2) {
    const labels = JSON.parse(ctx2.dataset.labels || '[]');
    const values = JSON.parse(ctx2.dataset.values || '[]');
    new Chart(ctx2, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{ data: values, backgroundColor: ['#4e79a7','#f28e2b','#e15759','#76b7b2'] }]
      },
      options: { plugins: { legend: { position: 'bottom' } } }
    });
  }
});
