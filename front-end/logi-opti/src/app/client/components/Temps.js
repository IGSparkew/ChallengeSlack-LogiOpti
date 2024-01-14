'use client'
import React, { useState,useEffect } from 'react';

export default function Temps({setSelectedTemps,setSelectedMoyen,selectedMoyen,selectedTemps,setReset,reset}) {
  const [selectedTab, setSelectedTab] = useState("day");
  const [selectedTabCamion, setSelectedTabCamion] = useState("dayCamion");

  const changeColorBg = (tab) => {

    if(tab == "year" || tab == "month")
    {
      setReset(!reset);
    }

      if(tab == "dayCamion" || tab == "monthCamion" || tab == "yearCamion")
      {
        setSelectedTabCamion(tab)
        setSelectedTab(tab);
        setSelectedTemps(tab);
        setSelectedMoyen("camion");
      }
      else if(tab == "day" || tab == "month" || tab == "year"){
        setSelectedTab(tab);
        setSelectedTabCamion(tab);
        setSelectedTemps(tab);
        setSelectedMoyen(tab);
      }
  };

  useEffect(() => {

    console.log("Use effect selected temps : ",selectedTemps)
    setSelectedTab(selectedTemps);
    setSelectedTabCamion(selectedTemps);
    
    
  }, [selectedTemps,selectedMoyen]);

  return (
    <div className="w-full flex justify-center">
      <div className="w-8/12 flex justify-around">
        <div
          onClick={() => {selectedMoyen != "camion" ? changeColorBg("day") : changeColorBg("dayCamion")}}
          className={`${
            selectedTab === "day" ? "bg-redFull" : selectedTabCamion == "dayCamion" ? "bg-redFull" : "bg-redFullClair2  cursor-pointer"
          } text-white rounded-lg px-16 py-2`}
        >
          <button className=''>
            <p className={`${selectedTab === "day" ? "text-white" : selectedTabCamion == "dayCamion" ? "text-white"  :"text-redFull"}`}>
              Jour
            </p>
          </button>
        </div>
        <div
          onClick={() => {selectedMoyen != "camion" ? changeColorBg("month") : changeColorBg("monthCamion")}}
          className={`${
            selectedTab === "month" ? "bg-redFull" : selectedTabCamion == "monthCamion" ? "bg-redFull" : "bg-redFullClair2  cursor-pointer"
          } text-white rounded-lg px-16 py-2`}
        >
          <button className=''>
            <p className={`${selectedTab === "month" ? "text-white" : selectedTabCamion == "monthCamion" ? "text-white" : "text-redFull"}`}>
              Mois
            </p>
          </button>
        </div>
        <div
          onClick={() => {selectedMoyen != "camion" ? changeColorBg("year") : changeColorBg("yearCamion")}}
          className={`${
            selectedTab === "year" ? "bg-redFull" : selectedTabCamion == "yearCamion" ? "bg-redFull" : "bg-redFullClair2  cursor-pointer"
          } text-white rounded-lg px-16 py-2 `}
        >
          <button className=''>
            <p className={`${selectedTab === "year" ? "text-white" : selectedTabCamion == "yearCamion" ? "text-white"  : "text-redFull"}`}>
              Annee
            </p>
          </button>
        </div>
      </div>
    </div>
  );
}