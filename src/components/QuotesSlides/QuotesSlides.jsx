import React from 'react'
import './QuotesSlides.css'

const QuotesSlides = () => {
  return (
    <div className="quotes">
        <div className="quotes-slides">
        <div className="quotes-slide">
            <h2>Lorem Ipsum</h2>
            <p>Lorem Ipsum dolor sit amet y to eso</p>
            <span><a href="#">Enlace</a></span>
        </div>
        <div className="quotes-slide">
            <h2>Lorem Ipsum</h2>
            <p>Lorem Ipsum dolor sit amet y to eso</p>
            <span><a href="#">Enlace</a></span>
        </div>

        <div className="quotes-slide">
            <h2>Lorem Ipsum</h2>
            <p>Lorem Ipsum dolor sit amet y to eso</p>
            <span><a href="#">Enlace</a></span>
        </div>

        <div className="quotes-slide">
            <h2>Lorem Ipsum</h2>
            <p>Lorem Ipsum dolor sit amet y to eso</p>
            <span><a href="#">Enlace</a></span>
        </div>

        <div className="quotes-slide">
            <h2>Lorem Ipsum</h2>
            <p>Lorem Ipsum dolor sit amet y to eso</p>
            <span><a href="#">Enlace</a></span>
        </div>


        <a className="prev">&#10094;</a>
        <a className="next">&#10095;</a>
        </div>
        <div className="quotes-index">
            <span className="dot"></span>
            <span className="dot"></span>
            <span className="dot"></span>
        
        </div>
    </div>
  )
}

export default QuotesSlides