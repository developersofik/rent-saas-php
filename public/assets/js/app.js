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
});
