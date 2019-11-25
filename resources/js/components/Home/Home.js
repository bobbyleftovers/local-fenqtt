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
    const screenshot = this.webcam.getScreenshot();
    this.setState({ screenshot: screenshot });
  };

  handleSubmit = () => {
    Axios.post('/create-submission', {
      screenshot: this.state.screenshot,
    })
      .then(res => {
        // check response, if all is well, trigger the upload
        Axios.get(`/upload-submission/${res.data.id}`).then(res => {
          console.log(res);
        });
      })
      .catch(error => {
        // log out the error
        let message = `ERROR: `;

        // loader
        this.tableLoading = false;

        // Error
        if (error.response) {
          // The request was made and the server responded with a status code
          // that falls out of the range of 2xx
          message +=
            error.response.status +
            `; ` +
            error.response.data.message;
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        } else if (error.request) {
          // The request was made but no response was received
          // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
          // http.ClientRequest in node.js
          message += error.request;
          console.log(error.request);
        } else {
          // Something happened in setting up the request that triggered an Error
          message += error.message;
          console.log('ERROR:', error.message);
        }
        console.log('ERROR CONFIG:', error.config, message);
        message += ` (see console)`;

        // Show toast with error message
        // this.$toast.open({
        //     duration: 5000,
        //     message: message,
        //     position: 'is-bottom',
        //     type: 'is-danger'
        // });
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
    return (
      <div>
        <Columns>
          <Columns.Column>
            <Box>
              <div className="card-header">
                <h1 className="title is-1">Photobooooth!</h1>
              </div>

              <div className="card-body">
                <h2 className="subtitle is-4">
                    Click the button to take snapshots for the photobooth! Bam!
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
}

export default Home;
