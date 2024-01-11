'use client'
import Header from "../components/Header";
import Sidebar from "../components/Sidebar";
import TopCards from "../components/TopCards";
import Table from '../components/table'
import MyDatePicker from "./components/DatePicker";
import SelecteurTemps from "./components/SelecteurTemps";
import Temps from "./components/Temps";
import { data1 } from '../data/data1';
import { data2 } from '../data/data2';
import { data3} from '../data/data3';
import { data4} from '../data/data4';
import { data5} from '../data/data5';
import { data6} from '../data/data6';
import React, { useState,useEffect } from 'react';
import ListeCamion from "./components/ListeCamion";


export default function Client() {

    const [selectedTemps, setSelectedTemps] = useState("day");
    const [dataFinal, setDataFinal] = useState(data1);
    const [selectedMoyen,setSelectedMoyen] =useState("trajet");



    useEffect(() => {
        
        if (selectedTemps == "day"){
            setDataFinal(data1);
        }
        else if(selectedTemps == "month"){
            setDataFinal(data2);
        }
        else if(selectedTemps == "year"){
            setDataFinal(data3);
        }
        else if(selectedTemps == "dayCamion"){
            setDataFinal(data4);
        }
        else if(selectedTemps == "monthCamion"){
            setDataFinal(data5);
        }
        else{
            setDataFinal(data6);

        }

        console.log("Temps dans page.js : ",selectedTemps)
    
    }, [selectedTemps]);

    useEffect(() => {
    
    }, [selectedMoyen]);


    const handleSelectedTemps = (data) => {
        console.log("dans la fonction handleSelectedTemps");
        console.log(data);
        setSelectedTemps(data)
    }

    const handleSelectedMoyen = (data) => {
        console.log("dans la fonction handleSelectedMoyen");
        console.log(data);
        setSelectedMoyen(data)
    }
    

    const conditionTime = selectedTemps === "month" || selectedTemps === "year";

    return (
        <main className="flex ">

            <Sidebar />
            <div className="flex-auto" >
                <Header />
                <TopCards />
                <Temps setSelectedTemps={handleSelectedTemps} setSelectedMoyen={setSelectedMoyen} selectedMoyen={selectedMoyen} selectedTemps={selectedTemps}/>
                { selectedTemps == "day" ? (
                    <MyDatePicker />
                ) : conditionTime ?(
                    <SelecteurTemps temps={selectedTemps}/>
                ) : (
                    <ListeCamion />
                )
                }
               
                <Table  data ={dataFinal} setSelectedMoyen={handleSelectedMoyen} setSelectedTemps={handleSelectedTemps} selectedTemps={selectedTemps}/>

                

            </div>

        </main>
    );
}
