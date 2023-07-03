import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faStar, faMusic, faFaceLaughBeam } from '@fortawesome/free-solid-svg-icons'
import './IconBox.css'
const IconBox = (props) => {

    const {title, icon, description} = props

    const iconMap = {
        faStar: faStar,
        faMusic: faMusic,
        faFaceLaughBeam: faFaceLaughBeam

    }
  return (
    <figure>
        <FontAwesomeIcon icon={iconMap[icon]} />
        <h2>{title}</h2>
        <p>{description}</p>
    </figure>
  )
}

export default IconBox