import React from 'react';
import { Doughnut } from 'react-chartjs-2';
import styles from '../../Styles/Admin.module.css';
import ChartDataLabels from 'chartjs-plugin-datalabels';

import {
  Chart as ChartJS,
  ArcElement,
  Tooltip,
  Legend,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title
} from 'chart.js';

ChartJS.register(
  ArcElement,
  Tooltip,
  Legend,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  ChartDataLabels
);

const specificProjectData = {
  datasets: [
    {
      label: 'Проекты',
      data: [450, 250, 300],
      backgroundColor: [
        '#DCDCDC',
        '#8B8B8B',
        '#BB2649'
      ],
      borderColor: [
        '#DCDCDC',
        '#8B8B8B',
        '#BB2649'
      ],
      borderWidth: 1,
      datalabels: {
        color: '#000',
        font: {
          size: 16,
        },
        formatter: (value) => value,
      },
    },
  ],
  labels: ['Завершённые', 'Просмотренные', 'В процессе'],
};

const total = specificProjectData.datasets[0].data.reduce((a, b) => a + b, 0);

const SpecificProject = () => (
  <div className={styles.chartWrapper}>
    <div className={styles.chartContainer}>
      <Doughnut 
        data={specificProjectData} 
        options={{
          plugins: {
            datalabels: {
              display: true,
              color: '#fff',
              formatter: (value, context) => value,
            },
            tooltip: {
              enabled: false,
            },
            legend: {
              display: false,
            },
            datalabels: {
              color: '#000',
              font: {
                size: 16,
              },
              formatter: (value) => value,
            },
          },
          cutout: '70%', // Adjust this value for the desired hole size
          centerText: {
            display: true,
            text: total.toString(),
          },
        }}
      />
      <div className={styles.centerText}>
        {total}
      </div>
      <div>
        <p className={styles.centerTextBottom}>Ивентов</p>
      </div>
    </div>
    <div className={styles.legend}>
      <div className={styles.legendItem}>
        <span className={styles.legendColor} style={{ backgroundColor: '#DCDCDC' }}></span>Завершённые
      </div>
      <div className={styles.legendItem}>
        <span className={styles.legendColor} style={{ backgroundColor: '#8B8B8B' }}></span>Просмотренные
      </div>
      <div className={styles.legendItem}>
        <span className={styles.legendColor} style={{ backgroundColor: '#BB2649' }}></span>В процессе
      </div>
    </div>
  </div>
);

export default SpecificProject;
