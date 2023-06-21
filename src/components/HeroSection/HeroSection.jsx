import React from 'react'
import './HeroSection.css'
const HeroSection = (props) => {

    const { title, subtitle, img, buttonText, handlerButton } = props

  return (
    <section>
        <h1>{title}</h1>
        <h2>{subtitle}</h2>
        <button onClick={handlerButton}>{buttonText}</button>
    </section>
  )
}

export default HeroSection