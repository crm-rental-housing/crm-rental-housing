import React, { Component } from "react";
import '../../Styles/HomePage.css'; 
import 'bootstrap/dist/css/bootstrap.min.css';
import { Button } from "react-bootstrap";
import AllProjects from './ComponentsHomePage/AllProjects';
import SpecificProject from './ComponentsHomePage/SpecificProject';
import TransactionForm from './ComponentsHomePage/TransactionForm';
import Object from './ComponentsHomePage/Object';
import StatisticsManagers from './ComponentsHomePage/StatisticsMan';
import DealStatistics from './ComponentsHomePage/DealStatistics'
import styles from '../../Styles/HomePage.module.css';

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
  Title
);

export default class HomePage extends Component {
  constructor(props) {
    super(props);
    this.state = {
      activeTab: 'all',
      showDealStatistics: false
    };
  }

  handleEditInfo = () => {
    console.log("Редактировать информацию");
  };

  setActiveTab = (tab) => {
    this.setState({ activeTab: tab });
  };

  toggleDealStatistics = () => {
    this.setState((prevState) => ({
      showDealStatistics: !prevState.showDealStatistics,
    }));
  };

  render() {
    const { activeTab, showDealStatistics } = this.state;

    return (
      <div>
        <div className={styles.companyName}>
          <h1 className={styles.title}>Company name</h1>
          <p className={styles.description}>
            {`Группа Аквилон - одна из ведущих девелоперских компаний, предоставляющих полный спектр услуг на рынке недвижимости, создана в Архангельске 13 октября 2003 года, более 18 лет на рынке.
            Входит в ТОП-20 крупнейших застройщиков страны, в 10-ку крупнейших застройщиков Санкт-Петербурга.
            Группа Аквилон признана системообразующим предприятием России.
            География присутствия: Москва, Санкт-Петербург, Ленинградская область, Архангельск, Северодвинск.`}
          </p>
          <div className={styles.contactInfo}>
            <p>mail.ua@gmail.com</p>
            <p><a href="http://website.www.com" target="_blank" className={styles.link}>website.www.com</a></p>
            <p>+123456789</p>
          </div>
          <Button className={styles.battonEdit} variant="primary" onClick={this.handleEditInfo}>
            Редактировать информацию
          </Button>
        </div>
        <div>
          <h2 className={styles.titleTransactionStatistics}>Статистика сделок</h2>
        </div>
        <div className={styles.Information}>
          <div className={styles.ProjectDeals}>
            <h2 className={styles.TransactionStatisticsProject}>Проекты</h2>
            <h2 className={styles.latestDeals}>Последние сделки</h2>
          </div>
          <div className={styles.statistics}>
            <div className={styles.tabButtons}>
              <Button
                variant={activeTab === 'all' ? 'danger' : 'Link'}
                onClick={() => this.setActiveTab('all')}
                className={styles.customButton}
              >
                Все
              </Button>
              <Button
                variant={activeTab === 'specific' ? 'danger' : 'Link'}
                onClick={() => this.setActiveTab('specific')}
                className={styles.customButton}
              >
                Название проекта
              </Button>
            </div>
            <div className={styles.chartContainer}>
              {activeTab === 'all' && <AllProjects />}
              {activeTab === 'specific' && <SpecificProject />}
              <div className={styles.transactionFieldsContainer}>
                <TransactionForm />
                <TransactionForm />
                <TransactionForm />
              </div>
            </div>
            <div className={styles.mainContainer}>
              <div className={styles.transactionFieldsContainer_2}>
                <Object />
                <Object />
                <Object />
              </div>
              <div className={styles.transactionFieldsContainer_3}>
                <StatisticsManagers />
                <StatisticsManagers />
                <StatisticsManagers />
              </div>
            </div>
          </div>
        </div>
        <div>
          <Button
            variant={showDealStatistics ? 'Link' : 'danger'}
            onClick={this.toggleDealStatistics}
            className={styles.customButton}
          >
            Все
          </Button>
          <div className={styles.chartContainer}>
            {showDealStatistics && <DealStatistics />}
          </div>
        </div>
      </div>
    );
  }
}
