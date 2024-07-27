import React, { Component } from "react";
// import '../../Styles/HomePage.css';

export default class Site extends Component {
    handleEditInfo = () => {
        // Добавьте здесь логику для редактирования информации
        console.log("Редактировать информацию");
    };

    render() {
        return (
            <div className="home-content">
                <h1>Site</h1>
                <p>
                    {`Группа Аквилон - одна из ведущих девелоперских компаний, предоставляющих полный спектр услуг на рынке недвижимости, создана в Архангельске 13 октября 2003 года, более 18 лет на рынке.
                    Входит в ТОП-20 крупнейших застройщиков страны, в 10-ку крупнейших застройщиков Санкт-Петербурга.
                    Группа Аквилон признана системообразующим предприятием России.
                    География присутствия: Москва, Санкт-Петербург, Ленинградская область, Архангельск, Северодвинск.`}
                </p>
                <div className="contact-info">
                    <p>mail.ua@gmail.com</p>
                    <p><a href="http://website.www.com" target="_blank">website.www.com</a></p>
                    <p>+123456789</p>
                </div>
                <button onClick={this.handleEditInfo}>Редактировать информацию</button>
                {/* Добавьте здесь основной контент вашей главной страницы */}
            </div>
        );
    }
}
