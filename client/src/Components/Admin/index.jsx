import React, { useState } from "react";
import { useSelector } from "react-redux";
import { Button } from "react-bootstrap";
import { NavLink } from "react-router-dom"; // Импортируем NavLink
import AllProjects from './ComponentAdmin/AllProjects';
import SpecificProject from './ComponentAdmin/SpecificProject';
import TransactionForm from './ComponentAdmin/TransactionForm';
import Object from './ComponentAdmin/Object';
import StatisticsManagers from './ComponentAdmin/StatisticsMan';
import DealStatistics from './ComponentAdmin/DealStatistics';
import styles from '../Styles/Admin.module.css';

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

const HomePage = () => {
  const [activeTab, setActiveTab] = useState('all');
  const [showDealStatistics, setShowDealStatistics] = useState(false);

  const auth = useSelector((state) => state.auth.currentUser);

  const handleEditInfo = () => {
    console.log("Редактировать информацию");
  };

  const toggleDealStatistics = () => {
    setShowDealStatistics((prevState) => !prevState);
  };

  return (
    <div>
      <div className={styles.navLinks}>
        <NavLink to="/users">Пользователи</NavLink>
        <NavLink to="/companies">Компании</NavLink>
        <NavLink to="/projects">Проекты</NavLink>
        <NavLink to="/entities">Объекты</NavLink>
        <NavLink to="/appartments">Квартиры</NavLink>
        <NavLink to="/managers">Менеджеры</NavLink>
      </div>
      <div className={styles.companyName}>
        <h1 className={styles.title}>Admin panel</h1>
        <p className={styles.description}>
          {`Группа Аквилон - одна из ведущих девелоперских компаний, предоставляющих полный спектр услуг на рынке недвижимости, создана в Архангельске 13 октября 2003 года, более 18 лет на рынке.
          Входит в ТОП-20 крупнейших застройщиков страны, в 10-ку крупнейших застройщиков Санкт-Петербурга.
          Группа Аквилон признана системообразующим предприятием России.
          География присутствия: Москва, Санкт-Петербург, Ленинградская область, Архангельск, Северодвинск.`}
        </p>
        <div className={styles.contactInfo}>
          <div>{auth.email}</div>
          <div>{auth.role}</div>
          <p><a href="http://website.www.com" target="_blank" rel="noopener noreferrer" className={styles.link}>website.www.com</a></p>
          <p>+123456789</p>
        </div>
        <Button className={styles.battonEdit} variant="primary" onClick={handleEditInfo}>
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
              onClick={() => setActiveTab('all')}
              className={styles.customButton}
            >
              Все
            </Button>
            <Button
              variant={activeTab === 'specific' ? 'danger' : 'Link'}
              onClick={() => setActiveTab('specific')}
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
          onClick={toggleDealStatistics}
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
};

export default HomePage;
