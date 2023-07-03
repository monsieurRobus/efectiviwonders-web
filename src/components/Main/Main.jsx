import React from 'react'
import HeroSection from '../HeroSection/HeroSection'
import IconSection from '../IconBox/IconSection'
import Description from '../Description/Description'
import QuotesSlides from '../QuotesSlides/QuotesSlides'

const Main = () => {
  return (
    <main>
        <HeroSection title={'Somos tu festival'} subtitle={'La mejor orquesta indie rock'} buttonText={"Quiero mas info"} buttonHandler={()=>console.log('lalal')} img={"https://picsum.photos/500"}/>
        <Description />
        <IconSection />
        <HeroSection title={'¿Quieres más información?'} subtitle={'Ponte en contacto con nosotros a través de este formulario.'} buttonText={"Quiero mas info"} buttonHandler={()=>console.log('lalal')} img={"https://picsum.photos/500"}/>
        <QuotesSlides />
    </main>
  )
}

export default Main