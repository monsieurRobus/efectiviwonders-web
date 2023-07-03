import React from 'react'
import './HeroSection.css'
const HeroSection = (props) => {

    const { title, subtitle, img, buttonText, buttonHandler } = props

  return (
    <section>
        <h1>{title}</h1>
        <h2>{subtitle}</h2>
        <button onClick={buttonHandler}>{buttonText}</button>
    </section>
  )
}

export default HeroSection