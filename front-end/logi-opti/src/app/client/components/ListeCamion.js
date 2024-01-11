"use client";
import React, { useState } from 'react';

const ListeCamion = () => {


    const [selectedCamion, setSelectedCamion] = useState(null);
  const [isOpen, setIsOpen] = useState(false);


    const toggleDropdown = () => {
        setIsOpen(!isOpen);
      };
    
      const closeDropdown = () => {
        setIsOpen(false);
      };

      const handleCamionChange = (event) => {
        const selectedValue = event.target.value;
        setSelectedCamion(selectedValue);
        closeDropdown();
      };
    

    const camions = [
        'Camion A', 'Camion B', 'Camion C'
      ];

  return (
    <div className='w-full flex justify-center mt-10 gap-5'>
  
        <div className="relative inline-block text-left w-1/12">
            <select
            className="text-redFull block px-3 py-2 text-sm w-full text-left focus:outline-none bg-white border-2 border-redFull rounded w-full"
            onChange={handleCamionChange}
            value={selectedCamion || ''}
            >
            <option value="" disabled>Type de vehicule</option>
            {camions.map((camion, index) => (
                <option key={index} value={camion}>{camion}</option>
            ))}
            </select>
        </div>
    </div>
  );
};

export default ListeCamion;