import React from 'react'
import HeroSection from '../HeroSection/HeroSection'

const Main = () => {
  return (
    <main>
        <HeroSection title={'Somos tu festival'} subtitle={'La mejor orquesta indie rock'} buttonText={"Quiero mas info"} buttonHandler={()=>console.log('lalal')} img={"https://picsum.photos/500"}/>

    </main>
  )
}

export default Main