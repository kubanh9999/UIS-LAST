Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Dữ liệu ảo cho biểu đồ
const mockData = [
    { label: 'Doanh nghiệp A', count: 10 },
    { label: 'Doanh nghiệp B', count: 15 },
    { label: 'Doanh nghiệp C', count: 20 },
    { label: 'Doanh nghiệp D', count: 25 },
];

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: mockData.map(item => item.label), // Cập nhật nhãn từ dữ liệu ảo
        datasets: [{
            label: "Số doanh nghiệp",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: mockData.map(item => item.count), // Cập nhật dữ liệu từ dữ liệu ảo
        }],
    },
});
