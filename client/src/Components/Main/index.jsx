import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import styles from "../Styles/Main.module.css";

const Main = () => {
  return (
    <div className={styles.container}>
      <header className={`${styles.header} text-center`}>
        {/* <h1>Наши предложения</h1> */}
        <form className={`d-flex ${styles.searchForm}`}>
          <input
            type="text"
            className={`form-control ${styles.searchInput}`}
            placeholder="Поиск по городу, району, адресу..."
          />
          <button
            type="submit"
            className={`btn btn-primary ${styles.searchButton}`}
          >
            Найти
          </button>
        </form>
      </header>

      <section className={`${styles.propertyList} container my-5`}>
        <h2 className="text-center mb-4">Наши объекты</h2>
        <div id="propertyCarousel" className="carousel slide">
          <div className="carousel-inner">
            <div className="carousel-item active">
              <div className="row">
                <div className="col-md-4 mb-4">
                  <div className="card">
                    <img
                      src="https://via.placeholder.com/300"
                      alt="Property"
                      className="card-img-top"
                    />
                    <div className="card-body">
                      <h5 className="card-title">Квартира в центре города</h5>
                      <p className="card-text">
                        Просторная квартира с двумя спальнями и балконом.
                        Ремонт, современная мебель.
                      </p>
                      <p className="card-text font-weight-bold">3 500 000 ₽</p>
                    </div>
                  </div>
                </div>
                <div className="col-md-4 mb-4">
                  <div className="card">
                    <img
                      src="https://via.placeholder.com/300"
                      alt="Property"
                      className="card-img-top"
                    />
                    <div className="card-body">
                      <h5 className="card-title">Дом с участком</h5>
                      <p className="card-text">
                        Уютный дом с большим участком. Отличное место для
                        семейного отдыха.
                      </p>
                      <p className="card-text font-weight-bold">7 000 000 ₽</p>
                    </div>
                  </div>
                </div>
                {/* Добавьте больше объектов недвижимости по необходимости */}
              </div>
            </div>
            <div className="carousel-item">
              <div className="row">
                <div className="col-md-4 mb-4">
                  <div className="card">
                    <img
                      src="https://via.placeholder.com/300"
                      alt="Property"
                      className="card-img-top"
                    />
                    <div className="card-body">
                      <h5 className="card-title">Элитная квартира</h5>
                      <p className="card-text">
                        Роскошная квартира с панорамным видом на город.
                        Современные удобства и мебель.
                      </p>
                      <p className="card-text font-weight-bold">5 000 000 ₽</p>
                    </div>
                  </div>
                </div>
                <div className="col-md-4 mb-4">
                  <div className="card">
                    <img
                      src="https://via.placeholder.com/300"
                      alt="Property"
                      className="card-img-top"
                    />
                    <div className="card-body">
                      <h5 className="card-title">Дом на берегу</h5>
                      <p className="card-text">
                        Дом у воды с просторной террасой. Идеально для любителей
                        природы.
                      </p>
                      <p className="card-text font-weight-bold">10 000 000 ₽</p>
                    </div>
                  </div>
                </div>
                {/* Добавьте больше объектов недвижимости по необходимости */}
              </div>
            </div>
            {/* Добавьте больше слайдов по необходимости */}
          </div>
          <a
            className="carousel-control-prev"
            href="#propertyCarousel"
            role="button"
            data-slide="prev"
          >
            <span
              className="carousel-control-prev-icon"
              aria-hidden="true"
            ></span>
            <span className="sr-only">Предыдущий</span>
          </a>
          <a
            className="carousel-control-next"
            href="#propertyCarousel"
            role="button"
            data-slide="next"
          >
            <span
              className="carousel-control-next-icon"
              aria-hidden="true"
            ></span>
            <span className="sr-only">Следующий</span>
          </a>
        </div>
      </section>

      <section className={`${styles.advantages} container my-5`}>
        <h2 className="text-center mb-4">Наши преимущества</h2>
        <div className="row">
          <div className="col-md-4 text-center mb-4">
            <i className="bi bi-house-door-fill display-4 text-primary"></i>
            <h3>Широкий выбор</h3>
            <p>
              Лучшие предложения на рынке недвижимости, от квартир до домов.
            </p>
          </div>
          <div className="col-md-4 text-center mb-4">
            <i className="bi bi-cash-stack display-4 text-primary"></i>
            <h3>Доступные цены</h3>
            <p>Мы предлагаем конкурентные цены и гибкие условия оплаты.</p>
          </div>
          <div className="col-md-4 text-center mb-4">
            <i className="bi bi-people-fill display-4 text-primary"></i>
            <h3>Профессиональная команда</h3>
            <p>Наши эксперты помогут вам сделать лучший выбор.</p>
          </div>
        </div>
      </section>

      <section className={`${styles.gallery} container my-5`}>
        <h2 className="text-center mb-4">Галерея</h2>
        <div id="galleryCarousel" className="carousel slide">
          <div className="carousel-inner">
            <div className="carousel-item active">
              <img
                src="https://via.placeholder.com/600x400"
                alt="Gallery"
                className="d-block w-100"
              />
            </div>
            <div className="carousel-item">
              <img
                src="https://via.placeholder.com/600x400"
                alt="Gallery"
                className="d-block w-100"
              />
            </div>
            <div className="carousel-item">
              <img
                src="https://via.placeholder.com/600x400"
                alt="Gallery"
                className="d-block w-100"
              />
            </div>
            {/* Добавьте больше изображений по необходимости */}
          </div>
          <a
            className="carousel-control-prev"
            href="#galleryCarousel"
            role="button"
            data-slide="prev"
          >
            <span
              className="carousel-control-prev-icon"
              aria-hidden="true"
            ></span>
            <span className="sr-only">Предыдущий</span>
          </a>
          <a
            className="carousel-control-next"
            href="#galleryCarousel"
            role="button"
            data-slide="next"
          >
            <span
              className="carousel-control-next-icon"
              aria-hidden="true"
            ></span>
            <span className="sr-only">Следующий</span>
          </a>
        </div>
      </section>
    </div>
  );
};

export default Main;
