import React from 'react';
import ReactDOM from 'react-dom';
import * as newPickup_module from './../Feedback';

import renderer from "react-test-renderer";
import Rating from './../Rating';

export function handleChange(){
    const result = newPickup_module.handleChange;
    return result;
}

it("matches snapshot", () => {
    const tree = renderer.create(<Rating rating="" handleChange = {handleChange} size = {'36px'} />).toJSON();
    expect(tree).toMatchSnapshot();
})
