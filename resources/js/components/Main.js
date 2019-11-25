import React, { Component } from 'react'
import { Route } from 'react-router-dom'

import Home from './Home/Home'
// import Config from './Config/Config';
// import SubmissionMain from './Submissions/SubmissionMain';
import Container from 'react-bulma-components/lib/components/container'

class Main extends Component {
  constructor (props) {
    super(props)
    this.state = {
      // response: null
    }
  }

  render () {
    return (
      <Container>
        <Route path='/' exact component={Home} />
      </Container>
    )
  }
}

export default Main
