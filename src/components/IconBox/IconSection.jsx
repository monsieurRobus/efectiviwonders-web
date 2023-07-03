import React from 'react'
import {details} from './details'
import './IconSection.css'
import IconBox from './IconBox'

const IconSection = () => {
  return (
    <section className="iconSection">
      {
        details.map((detail, index) => {
          return (
            <IconBox key={index} {...detail} />
          )
        })
      }
    </section>
  )
}

export default IconSection