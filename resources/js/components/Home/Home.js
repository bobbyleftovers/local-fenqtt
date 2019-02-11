import React, { Component } from 'react';

import Columns from 'react-bulma-components/lib/components/columns';
import Box from 'react-bulma-components/lib/components/box';
import Button from 'react-bulma-components/lib/components/button';

import Webcam from 'react-webcam';
import Axios from 'axios';

class Home extends Component {
    setRef = webcam => {
        this.webcam = webcam;
    };
    constructor(props) {
        super(props);
        this.state = {
            screenshot: null,
        };
    }

    handleCapture = () => {
        console.log('click');
        const screenshot = this.webcam.getScreenshot();
        this.setState({ screenshot: screenshot });
    };

    handleSubmit = () => {
        console.log(this.state.screenshot);
        Axios.post('/create-submission', {
            screenshot: this.state.screenshot,
        }).then(res => {
            console.log(res);

            // check response, if all is well, trigger the upload
            Axios.get(`/upload/${res.data.id}`).then(res => {
                console.log(res);
            });
        });
    };

    render() {
        let screenshot = null;
        if (this.state.screenshot) {
            screenshot = (
                <div>
                    <img src={this.state.screenshot} />
                    <hr />
                    <Button onClick={this.handleSubmit}>Use This One</Button>
                </div>
            );
        }
        const videoConstraints = {
            width: 1280,
            height: 720,
            facingMode: 'user',
        };
        console.log(this.setRef);
        return (
            <div>
                <Columns>
                    <Columns.Column>
                        <Box>
                            <div className="card-header">
                                <h1 className="title is-1">The Brite Lites</h1>
                            </div>

                            <div className="card-body">
                                <h2 className="subtitle is-4">
                                    Click the button to take your photo
                                </h2>
                            </div>
                        </Box>
                    </Columns.Column>
                </Columns>
                <Columns>
                    <Columns.Column>
                        <Webcam
                            audio={false}
                            ref={this.setRef}
                            screenshotFormat="image/jpeg"
                            videoConstraints={videoConstraints}
                        />
                        <hr />
                        <Button onClick={this.handleCapture}>Capture</Button>
                    </Columns.Column>
                    <Columns.Column>{screenshot}</Columns.Column>
                </Columns>
            </div>
        );
    }

    // capture = () =>
    // {
    //     const imageSrc = this.webcam.getScreenshot();
    // };

    // render()
    // {

    //     return (
    //         <div>
    //             <button onClick={this.capture}>Capture photo</button>
    //         </div>
    //     );
    // }
}

export default Home;
