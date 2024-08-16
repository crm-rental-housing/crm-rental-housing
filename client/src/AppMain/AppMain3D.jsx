import React, { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import './AppMain3D.css';

const AppMain3D = () => {
  const navigate = useNavigate(); // Инициализация navigate

  useEffect(() => {
    const canvas = document.getElementsByClassName('rain')[0];
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const c = canvas.getContext('2d');

    function randomNum(max, min) {
      return Math.floor(Math.random() * max) + min;
    }

    function RainDrops(x, y, endy, velocity, opacity) {
      this.x = x;
      this.y = y;
      this.endy = endy;
      this.velocity = velocity;
      this.opacity = opacity;

      this.draw = function() {
        c.beginPath();
        c.moveTo(this.x, this.y);
        c.lineTo(this.x, this.y - this.endy);
        c.lineWidth = 1;
        c.strokeStyle = "rgba(255, 255, 255, " + this.opacity + ")";
        c.stroke();
      }

      this.update = function() {
        let rainEnd = window.innerHeight + 100;
        if (this.y >= rainEnd) {
          this.y = this.endy - 100;
        } else {
          this.y = this.y + this.velocity;
        }
        this.draw();
      }
    }
    
    const rainArray = [];

    for (let i = 0; i < 140; i++) {
      const rainXLocation = Math.floor(Math.random() * window.innerWidth) + 1;
      const rainYLocation = Math.random() * -500;
      const randomRainHeight = randomNum(10, 2);
      const randomSpeed = randomNum(20, 0.2);
      const randomOpacity = Math.random() * 0.55;
      rainArray.push(new RainDrops(rainXLocation, rainYLocation, randomRainHeight, randomSpeed, randomOpacity));
    }

    function animateRain() {
      requestAnimationFrame(animateRain);
      c.clearRect(0, 0, window.innerWidth, window.innerHeight);

      for (let i = 0; i < rainArray.length; i++) {
        rainArray[i].update();
      }
    }

    animateRain();

    const handleMouseMove = (e) => {
      document.documentElement.style.setProperty('--move-x', `${(e.clientX - window.innerWidth / 2) * -0.005}deg`);
      document.documentElement.style.setProperty('--move-y', `${(e.clientY - window.innerHeight / 2) * 0.01}deg`);
    }

    document.addEventListener('mousemove', handleMouseMove);

    return () => {
      document.removeEventListener('mousemove', handleMouseMove);
    }
  }, []);

  // Определите функции для обработки кнопок
  const handleLogin = () => {
    navigate('/login');
  };

  const handleRegistration = () => {
    navigate('/registration');
  };

  const handleLearnMore = () => {
    navigate('/main');
  };

  return (
    <div>
      <div className="button-container">
        <button className="button-start_reg_1" onClick={handleLogin}>Вход</button>
        <button className="button-start_reg_2" onClick={handleRegistration}>Регистрация</button>
      </div>
      <div className="logo" style={{ backgroundImage: 'url(/img/logo.png)' }}></div>
      <section className="layers">
        <div className="layers__container">
          <div className="layers__item layer-1" style={{ backgroundImage: 'url(/img/layer-1.jpg)' }}></div>
          <div className="layers__item layer-2" style={{ backgroundImage: 'url(/img/layer-2.png)' }}></div>
          <div className="layers__item layer-3">
            <div className="hero-content">
              <h1 className="Text_hello">Добро пожаловать!</h1>
              <button className="button-start" onClick={handleLearnMore}>Узнать больше</button>
            </div>
          </div>
          <div className="layers__item layer-4">
            <canvas className="rain"></canvas>
          </div>
          <div className="layers__item layer-5" style={{ backgroundImage: 'url(/img/layer-5.png)' }}></div>
          <div className="layers__item layer-6" style={{ backgroundImage: 'url(/img/layer-6.png)' }}></div>
        </div>
      </section>
    </div>
  );
};

export default AppMain3D;
