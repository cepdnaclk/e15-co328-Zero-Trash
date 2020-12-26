import React from 'react';
import ReactDOM from 'react-dom';
import FormPickupDetails from './../FormPickupDetails';
import * as newPickup_module from './../../newPickup';

import Adapter from 'enzyme-adapter-react-16';
import { shallow, configure } from 'enzyme';

configure({ adapter: new Adapter() })
import {render} from "@testing-library/react";
import "@testing-library/jest-dom/extend-expect";

export function handleChange(){
    const result = newPickup_module.handleChange;
    return result;
}

export function nextStep(){
    const result = newPickup_module.nextStep;
    return result;
}


export const values = {
    phoneNo: '0763914094',
    address: 'Sanhinda, Komarikagoda, Bandarawela',
    municipal: 'Bandarawela'
};

it("Pickup details form renders without crashing", () => {
    const div = document.createElement('div');
    
    ReactDOM.render(               
    <FormPickupDetails
        nextStep = {nextStep}
        handleChange = {handleChange}
        values = {values}
        />, div);
});

it("Phone Number updates correctly", () => {
    const {getByTestId} = render(
        <FormPickupDetails
            nextStep = {nextStep}
            handleChange = {handleChange}
            values = {values}
            />);
    //console.log(expect(getByTestId('phoneNo')))
    expect(getByTestId('phoneNo').defaultValue).toBe("0763914094");
});

it("Address updates correctly", () => {
    const {getByTestId} = render(
        <FormPickupDetails
            nextStep = {nextStep}
            handleChange = {handleChange}
            values = {values}
            />);
    //console.log(expect(getByTestId('phoneNo')))
    expect(getByTestId('address').defaultValue).toBe("Sanhinda, Komarikagoda, Bandarawela");
});

configure({adapter: new Adapter()});
it("Phone Nnumber validation successful", () => {

    let phoneNoList = [];
    phoneNoList.push('071391409');
    phoneNoList.push('07580098989');
    phoneNoList.push('0113456789');
    phoneNoList.push('0572224750');

    for(let num in phoneNoList)
    {
        values.phoneNo = num;
        const wrapper = shallow(
            <FormPickupDetails
                nextStep = {nextStep}
                handleChange = {handleChange}
                values = {values}
                />);
        
        wrapper.instance().continue();
        expect(wrapper.state('validPhoneNo')).toStrictEqual(false);
    }
})

